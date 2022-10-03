<?php

namespace App\Console\Commands;

use App\Models\Beat;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Part;
use App\Models\Purchase;
use App\Models\Service;
use App\Models\User;
use App\Traits\GravatarTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class DgraphImporterCommand extends Command
{
    use GravatarTrait;

    protected $signature = 'dgraph:import {path}';

    protected $description = 'Import Dgraph export into database';

    public function handle()
    {
        $path = $this->argument('path');
        $contents = file_get_contents($path);
        if (!$contents) {
            $this->output->write('Could not open file');
            return;
        }

        $jsonContent = json_decode($contents, true);
        $data = [];
        $types = [];
        foreach ($jsonContent as $item) {
            if (isset($data[$item['uid']])) {
                $data[$item['uid']] = array_merge(
                    $data[$item['uid']],
                    $item
                );
            } else {
                $data[$item['uid']] = $item;
            }

            if (isset($item['type'])) {
                if (isset($types[$item['type']])) {
                    $types[$item['type']]++;
                } else {
                    $types[$item['type']] = 1;
                }
            }
        }



        $dataByTypes = [];
        foreach ($types as $type => $qty) {
            $dataByTypes[$type] = array_filter($data, function ($item) use ($type) {
                return isset($item['type']) && $item['type'] == $type;
            });
        }

        $userErrors = [];
        $beatErrors = [];
        $purchaseErrors = [];
        $i = 0;
        foreach ($dataByTypes['user'] as $user) {
            try {
                $this->createUser($user);
            } catch (\Exception $e) {
                $this->output->writeln($e->getMessage());
                $userErrors[] = $user;
            }
        }
        foreach ($dataByTypes['beat'] as $beat) {
            try {
                $this->createBeat($beat);
            } catch (\Exception $e) {
                $beatErrors[] = $beat;
            }
        }
        foreach ($dataByTypes['inactive.beat'] as $beat) {
            try {
                $this->createBeat($beat);
            } catch (\Exception $e) {
                $beatErrors[] = $beat;
            }
        }
        foreach ($dataByTypes['deleted.beat'] as $beat) {
            try {
                $this->createBeat($beat);
            } catch (\Exception $e) {
                $beatErrors[] = $beat;
            }
        }
        foreach ($dataByTypes['unprinted.beat'] as $beat) {
            try {
                $this->createBeat($beat);
            } catch (\Exception $e) {
                $beatErrors[] = $beat;
            }
        }
        foreach ($dataByTypes['purchased.beat'] as $beat) {
            try {
                $this->createBeat($beat);
            } catch (\Exception $e) {
                $beatErrors[] = $beat;
            }
        }

        foreach ($dataByTypes['purchase'] as $purchase) {
            try {
                $this->createPurchase($purchase);
            } catch (\Exception $e) {
                $this->output->writeln($e->getMessage());
                $purchaseErrors[] = $purchase;
            }
        }

        foreach ($dataByTypes['comment'] as $comment) {
            try {
                $this->createComment($comment);
            } catch (\Throwable $e) {
                $this->output->writeln($e->getMessage());
//                $commentErrors[] = $user;
            }
        }

        $matchIds = [];
        foreach ($userErrors as $userError) {
            $user = User::where('email', '=', $userError['email'])->first();
            if ($user) {
                $matchIds[$userError['uid']] = $user->old_id;
                if (isset($userError['mediaGenre'])) {
                    foreach ($userError['mediaGenre'] as $item) {
                        try {
                            $genre = Genre::where('old_id', '=', $item['uid'])->firstOrFail();
                            $user->genres()->attach($genre->id);
                        } catch (\Exception $e) {
                            $this->output->writeln("Failed to assign genre ". $item['uid'] . 'to user' . $user->id);
                            $this->output->writeln($e->getMessage());
                        }
                    }
                }
            }
        }

        $this->output->writeln('');
        $this->output->writeln('Trying to fix beat errors');

        foreach ($beatErrors as $beatError) {
            $uid = $beatError['uploadedBy'][0]['uid'];

            if (isset($matchIds[$uid])) {
                $beatError['uploadedBy'][0]['uid'] = $matchIds[$uid];
            }

            foreach ($beatError['mediaGenre'] as &$genre) {
                if ($genre['uid'] === '0x30e7f') {
                    $genre['uid'] = '0x1cff06';
                }
            }

            $beat = Beat::withTrashed()->where('old_id', '=', $beatError['uid'])->first();
            if ($beat) {
                foreach ($beatError['mediaGenre']  as $mg) {
                    $g = Genre::where('old_id', '=', $mg['uid'])->first();
                    $beat->genres()->attach($g->id);
                }
            } else {
                try {
                    $this->createBeat($beatError);
                } catch (\Exception $e) {
                    $this->output->writeln($e->getMessage());
                    $beatErrors[] = $beatError;
                }
            }
        }

        $this->output->writeln("User errors: " . count($userErrors));
        $this->output->writeln("Beat errors: " . count($beatErrors));
        $this->output->writeln("Purchase errors: " . count($purchaseErrors));
    }

    private function createUser(array $u)
    {
        $user = new User();
        $user->about = $u['about'] ?? '';
        $user->email = $u['email'];
        $user->name = $u['name'];
        $user->password = Hash::make($u['password']);
        $user->email_verified_at = $u['verifiedAt'];
        $user->created_at = $u['registeredAt'];
        $user->old_id = $u['uid'];
        $user->profile_image_url = $u['profileImageUrl'] ?? $this->get_gravatar($u['email']);

        $user->save();

        if (isset($u['mediaGenre'])) {
            foreach ($u['mediaGenre'] as $item) {
                try {
                    $genre = Genre::where('old_id', '=', $item['uid'])->firstOrFail();
                    $user->genres()->attach($genre->id);
                } catch (\Exception $e) {
                    $this->output->writeln("Failed to assign genre ". $item['uid'] . 'to user' . $user->id);
                    $this->output->writeln($e->getMessage());
                }
            }
        }

        if (isset($u['service'])) {
            foreach ($u['service'] as $item) {
                try {
                    $service = Service::where('old_id', '=', $item['uid'])->firstOrFail();
                    $user->services()->attach($service->id);
                } catch (\Exception $e) {
                    $this->output->writeln("Failed to assign service ". $item['uid'] . 'to user' . $user->id);
                    $this->output->writeln($e->getMessage());
                }
            }
        }

    }

    private function createBeat(array $b)
    {
        $beat = new Beat();
        $beat->price = $b['price'];
        $beat->is_free = $b['isFree'] == "true" ? 1 : 0;
        $beat->weight = $b['weight'];
        $beat->name = $b['name'];
        $beat->play_url = $b['playUrl'] ?? '';
        $beat->artwork_url = $b['artworkUrl'] ?? '';
        $beat->is_exclusive = $b['isExclusive'] ? 1 : 0;
        $beat->created_at = $b['uploadedAt'];
        $beat->description = $b['description'];
        $beat->download_url = $b['downloadUrl'] ?? '';
        $beat->user_id = User::where('old_id', '=', $b['uploadedBy'][0]['uid'])->first()->id;
        $beat->duration = $b['length'] ?? 0;
        $beat->download_enabled = $b['downloadEnabled'] ? 1 : 0;
        $beat->purchase_enabled = $b['purchaseEnabled'] ? 1 : 0;
        $beat->old_id = $b['uid'];
        $beat->status = Beat::STATUSES['AVAILABLE'];
        if ($b['type'] === 'deleted.beat') {
            $beat->deleted_at = $b['type|deleted'];
            $beat->status = Beat::STATUSES['DELETED'];
        }
        if ($b['type'] === 'purchased.beat') {
            $beat->status = Beat::STATUSES['PURCHASED'];
        }
        if ($b['type'] === 'unprinted.beat') {
            $beat->status = Beat::STATUSES['UNPRINTED'];
        }
        if ($b['type'] === 'inactive.beat') {
            $beat->status = Beat::STATUSES['INACTIVE'];
        }
        $beat->save();

        foreach ($b['mediaGenre'] as $g) {
            $genre = Genre::where('old_id', '=', $g['uid'])->first();
            $beat->genres()->attach($genre->id);
        }

        $parts = explode(",", $b['parts']);
        foreach ($parts as $p) {
            $part = Part::where('name', '=', $p)->first();
            if ($part) {
                $beat->parts()->attach($part->id);
            }
        }
    }

    private function createPurchase(array $p)
    {
        $purchase = new Purchase();
        $purchase->price = $p['price'];
        $purchase->created_at = $p['purchasedAt'];
        $purchase->confirmed_at = Carbon::createFromTimeString($p['purchasedAt']);
        $purchase->old_id = $p['uid'];
        $purchase->user_id = User::where('old_id', '=', $p['purchasedBy'][0]['uid'])->first()->id;
        $purchase->save();

        foreach ($p['purchasedMedia'] as $beat) {
            $b = Beat::withTrashed()->where('old_id', '=', $beat['uid'])->first();
            $purchase->beats()->attach($b->id, [
                'price' => $b->price
            ]);
        }
    }

    private function createComment(array $c)
    {
        $comment = new Comment();
        $comment->content = $c['commentText'];
        $comment->created_at = $c['commentedAt'];
        $comment->user_id = User::where('old_id', '=', $c['commentedBy'][0]['uid'])->firstOrFail()->id;
        $comment->beat_id = Beat::where('old_id', '=', $c['commentedMedia'][0]['uid'])->firstOrFail()->id;
        $comment->old_id = $c['uid'];
        $comment->save();
    }
}
