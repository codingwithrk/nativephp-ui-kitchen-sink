<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class AttachmentExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    /** @var list<array{id: int, name: string, size: string}> */
    public array $attachments = [
        ['id' => 1, 'name' => 'Q3-report.pdf', 'size' => '2.4 MB'],
        ['id' => 2, 'name' => 'beach.jpg', 'size' => '840 KB'],
        ['id' => 3, 'name' => 'demo.mp4', 'size' => '12 MB'],
        ['id' => 4, 'name' => 'assets.zip', 'size' => '31 MB'],
    ];

    public function open(int $attachmentId): void
    {
        $this->toast('Opening '.collect($this->attachments)->firstWhere('id', $attachmentId)['name']);
    }

    public function detach(int $attachmentId): void
    {
        $this->attachments = array_values(array_filter(
            $this->attachments,
            fn (array $attachment): bool => $attachment['id'] !== $attachmentId,
        ));
    }
}
