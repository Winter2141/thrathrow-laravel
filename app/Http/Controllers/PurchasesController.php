<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeatResource;
use App\Models\Beat;
use App\Models\Purchase;
use App\Traits\S3Trait;
use Aws\S3\S3Client;
use Aws\S3\S3ClientTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Inertia\Inertia;

class PurchasesController extends Controller
{

    use S3Trait;
    /**
     * Display a listing of the resource.
     *

     */
    public function index()
    {
        $user = \Auth::user();
        $beats = Beat::with(['uploader', 'genres'])
            ->join('beat_purchase', 'beats.id', '=', 'beat_purchase.beat_id')
            ->join('purchases', 'beat_purchase.purchase_id', '=', 'purchases.id')
            ->where('purchases.user_id', '=', $user->id)
            ->orderBy('purchases.created_at', 'desc')
            ->select(['beats.*'])
            ->paginate(25);

        return Inertia::render('Purchases/Index', [
            'beats' => BeatResource::collection($beats),
        ]);
    }

    public function downloadUrl(Request $request, string $beatId)
    {
        $user = Auth::user();
        $beat = Beat::join('beat_purchase', 'beat_purchase.beat_id', '=', 'beats.id')
            ->join('purchases', 'purchases.id', '=', 'beat_purchase.purchase_id')
            ->where('purchases.user_id', '=', $user->id)
            ->where('beats.id', '=', $beatId)
            ->firstOrFail();

        $s3Client = new S3Client([
            'region' => getenv('AWS_DEFAULT_REGION'),
            'version' => '2006-03-01',
            'credentials' => [
                'key'    => getenv('AWS_ACCESS_KEY_ID'),
                'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        if (!$beat->download_url) {
            throw new UnauthorizedException();
        }

        $fileParts = explode('/', $beat->download_url);
        $key = $this->getPurchaseKey($fileParts[count($fileParts) - 1], $beatId);
        if ($beat->old_id) {
            $key = $this->getPurchaseKey($fileParts[count($fileParts) - 1], $fileParts[count($fileParts) - 2]);
        }



        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => getenv('AWS_BUCKET'),
            'Key' => $key,
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');

        return (string)$request->getUri();
    }


}
