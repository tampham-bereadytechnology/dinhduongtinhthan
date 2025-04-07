<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\EditRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         EditAction::make(),
    //     ];
    // }
}
