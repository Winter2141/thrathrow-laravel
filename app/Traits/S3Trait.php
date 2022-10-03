<?php


namespace App\Traits;


trait S3Trait
{
    private function getArtworkKey(string $name, string $id)
    {
        return sprintf(
            "beat/artwork/%s/artwork.%s",
            $id,
            pathinfo($name)['extension']
        );
    }

    private function getPreviewKey(string $name, string $id)
    {
        return sprintf(
            "beat/preview/%s/unprintedbeat.%s",
            $id,
            pathinfo($name)['extension']
        );
    }

    private function getPurchaseKey(string $name, string $id)
    {
        return sprintf(
            "beat/purchase/%d/purchase.%s",
            $id,
            pathinfo($name)['extension']
        );
    }
}
