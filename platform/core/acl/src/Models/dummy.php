<?php

namespace Botble\ACL\Models;

use Botble\ACL\Notifications\ResetPasswordNotification;
use Botble\ACL\Traits\PermissionTrait;
use Botble\Base\Supports\Avatar;
use Botble\Media\Models\MediaFile;
use Exception;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use RvMedia;
 
/**
 * @mixin \Eloquent
 */
class dummy extends Authenticatable
{
    use PermissionTrait;
    use Notifiable;
    
    

}