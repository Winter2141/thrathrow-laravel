<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeatResource;
use App\Http\Resources\CommentResource;
use App\Models\Beat;
use App\Models\Comment;
use App\Service\BeatsService;
use App\Traits\S3Trait;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Inertia\Inertia;
use Log;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenEncoded;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class BeatsController extends Controller
{
    use S3Trait;

    /**
     * @var BeatsService
     */
    protected $beatsService;

    /**
     * BeatsController constructor.
     * @param BeatsService $beatsService
     */
    public function __construct(BeatsService $beatsService)
    {
        $this->beatsService = $beatsService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:3'],
            'genre' => ['required', 'exists:genres,id', 'uuid'],
            'bpm' => ['required', 'integer', 'min:60'],
            'free' => ['required', 'string', 'in:yes,no'],
            'exclusive' => ['required_if:free,no', 'string', 'in:yes,no'],
            'parts' => ['required_if:exclusive,yes', 'array'],
            'parts.*' => ['uuid', 'unique', 'exists:parts,id'],
            'price' => ['required_if:free,no', 'numeric', 'min:0'],
            'artwork' => ['required', 'string', 'min:3'],
            'preview' => ['required', 'string', 'min:3'],
            'purchase' => ['required_if:free,no'],
        ]);

        $beat = $user->beats()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'bpm' => $data['bpm'],
            'is_free' => $data['free'] === "yes",
            'is_exclusive' => $data['exclusive'] === "yes",
            'status' => Beat::STATUSES['UNPRINTED'],
            'price' => $data['free'] === "yes" ? 0 : $data['price'],
            'download_enabled' => $data['free'] === "yes",
            'purchase_enabled' => $data['free'] === "no",
        ]);

        $beat->download_url = $data['free'] === "no" ? getenv('AWS_URL') . '/' . $this->getPurchaseKey($data['purchase'], $beat->id) : getenv('AWS_URL') . '/' . sprintf(
                "beat/preview/%s/preview.%s",
                $beat->id,
                pathinfo($data['preview'])['extension']
            );;
        $beat->play_url = getenv('AWS_URL') . '/' . sprintf(
                "beat/preview/%s/preview.%s",
                $beat->id,
                pathinfo($data['preview'])['extension']
            );
        $beat->artwork_url = env('AWS_URL') . '/' . $this->getArtworkKey($data['artwork'], $beat->id);
        $beat->save();

        $beat->genres()->attach($data['genre']);
        $beat->parts()->attach($data['parts']);

        $s3Client = new S3Client([
            'region' => getenv('AWS_DEFAULT_REGION'),
            'version' => '2006-03-01',
            'credentials' => [
                'key'    => getenv('AWS_ACCESS_KEY_ID'),
                'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);


        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => getenv('AWS_BUCKET'),
            'Key' => $this->getArtworkKey($data['artwork'], $beat->id),
            'ACL' => 'public-read'
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $artworkUrl = (string)$request->getUri();

        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => getenv('AWS_BUCKET'),
            'Key' => $this->getPreviewKey($data['preview'], $beat->id),
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $previewUrl = (string)$request->getUri();
        $purchaseUrl = null;

        if ($data['purchase']) {
            $cmd = $s3Client->getCommand('PutObject', [
                'Bucket' => getenv('AWS_BUCKET'),
                'Key' => $this->getPurchaseKey($data['purchase'], $beat->id),
            ]);
            $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
            $previewUrl = (string)$request->getUri();
        }

        return response()->json([
            'id' => $beat->id,
            'artwork' => $artworkUrl,
            'preview' => $previewUrl,
            'purchase' => $purchaseUrl,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Beat $beat
     */
    public function show(Beat $beat)
    {
        $comments = Comment::where('beat_id', $beat->id)
            ->with(['user'])
            ->withCount(['likes'])
            ->orderByDesc('created_at')
            ->paginate(20);
        $beat->uploader;

        return Inertia::render('Beats/Show', [
            'beat' => $beat,
            'comments' => CommentResource::collection($comments)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Beat $beat
     * @return \Illuminate\Http\Response
     */
    public function edit(Beat $beat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Beat $beat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beat $beat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Beat $beat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beat $beat)
    {
        //
    }

    public function trending(Request $request)
    {
        $genres = array_filter(explode(',', $request->get('genres')), function ($genre) {
            return strlen($genre) > 0;
        });
        $limit = (int)$request->get('limit');
        if ($limit < 10) {
            $limit = 10;
        } elseif ($limit > 100) {
            $limit = 100;
        }
        $minPrice = $request->get('min_price') ?? 0;
        $maxPrice = $request->get('max_price') ?? 99999;
        $minBpm = $request->get('min_bpm') ?? 0;
        $maxBpm = $request->get('max_bpm') ?? 300;
        $isFree = $request->get('is_free') ?? false;

        if ($limit < 10) {
            $limit = 10;
        } elseif ($limit > 100) {
            $limit = 100;
        }
        $beats = Beat::with(['uploader'])
            ->withCount('purchases')
            ->orderBy('purchases_count', 'desc')
            ->where('status', '=', Beat::STATUSES['AVAILABLE'])
            ->where('bpm', '>=', $minBpm)
            ->where('bpm', '<=', $maxBpm);

        if (!$isFree) {
            $beats = $beats->where('price', '<=', $maxPrice)
                ->where('price', '>=', $minPrice);
        } else {
            $beats = $beats->where(function ($query) {
                $query->where('is_free', '=', 1)
                    ->orWhere('price', '=', 0);
            });
        }

        if (count($genres) > 0) {
            $beats = $beats
                ->join('beat_genre', 'beats.id', '=', 'beat_genre.beat_id')
                ->whereIn('beat_genre.genre_id', $genres);
        }

        $beats = $beats->limit($limit)
            ->get();

        return BeatResource::collection($beats);
    }

    public function latest(Request $request)
    {
        $genres = array_filter(explode(',', $request->get('genres')), function ($genre) {
            return strlen($genre) > 0;
        });
        $beats = Beat::with(['uploader'])
            ->orderBy('beats.created_at', 'desc')
            ->where('status', '=', Beat::STATUSES['AVAILABLE']);

        if (count($genres) > 0) {
            $beats
                ->join('beat_genre', 'beats.id', '=', 'beat_genre.beat_id')
                ->whereIn('beat_genre.genre_id', $genres);
        }
        $beats = $beats->limit(10)
            ->get();

        return BeatResource::collection($beats);
    }

    public function imprintConfirm(Request $request, Beat $beat)
    {
        $authToken = $request->header('Authorization', null);
        if (!$authToken) {
            return response()->json([], 403);
        }

        if (!$this->verifyToken($authToken)) {
            return response()->json([], 403);
        }

        if ($beat->status === Beat::STATUSES['UNPRINTED']) {
            $beat->status = Beat::STATUSES['AVAILABLE'];
            $beat->save();
        }

        return response()->json([], 200);
    }

    private function verifyToken(string $token)
    {
        try {
            $tokenDecoded = \Firebase\JWT\JWT::decode($token, getenv('JWT_SECRET'), array('HS256'));
            return $tokenDecoded->email === getenv('BEAT_TAGGER_EMAIL')
                && $tokenDecoded->name === getenv('BEAT_TAGGER_NAME')
                && $tokenDecoded->type === (int)getenv('BEAT_TAGGER_TYPE')
                && $tokenDecoded->userId === (int)getenv('BEAT_TAGGER_ID');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
