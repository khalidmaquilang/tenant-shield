<?php

namespace App\Filament\Resources\InviteResource\Pages;

use App\Filament\Resources\InviteResource;
use App\Mails\UserInvitationMail;
use App\Models\Invite;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Mail;

class ManageInvites extends ManageRecords
{
    protected static string $resource = InviteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->createAnother(false)
                ->mutateFormDataUsing(function (array $data): array {
                    $data['code'] = substr(md5(rand(0, 9).$data['email'].time()), 0, 32);

                    return $data;
                })
                ->before(function (Actions\CreateAction $action, array $data) {
                    $user = filament()->getTenant()->members()->where('email', $data['email'])->first();
                    if ($user) {
                        Notification::make()
                            ->danger()
                            ->title('User already exist')
                            ->body('This user is already a member of this tenant.')
                            ->send();

                        $action->halt();
                    }
                })
                ->after(function (Invite $record) {
                    Mail::to($record->email)->send(new UserInvitationMail($record));
                })
                ->successNotificationTitle('Invitation sent successfully!'),
        ];
    }
}
