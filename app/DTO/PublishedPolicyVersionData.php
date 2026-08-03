<?php

namespace App\DTO;

class PublishedPolicyVersionData
{
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly string $version
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'version' => $this->version,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'],
            version: $data['version'],
        );
    }
}