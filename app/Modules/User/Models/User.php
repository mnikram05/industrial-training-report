<?php

declare(strict_types=1);

namespace App\Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Scout\Searchable;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use App\Modules\Role\Constants\RoleNameConstants;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Role\Constants\RolePermissionConstants;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property-read Password|null $passwordRecord
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, HasUuids, Impersonate, LogsActivity, Notifiable, Searchable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type_user_id',
        'name',
        'nric',
        'staff_number',
        'phone',
        'department_id',
        'grade_position_id',
        'position',
        'state_id',
        'district_id',
        'email',
        'status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly( $this->fillable )
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the user's password record.
     *
     * @return HasOne<Password, $this>
     */
    public function passwordRecord(): HasOne
    {
        return $this->hasOne( Password::class );
    }

    /**
     * Persist a password for this user.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'deleted_by' );
    }

    public function storePassword( string $password ): void
    {
        $passwordRecord = $this->passwordRecord()->updateOrCreate(
            ['user_id' => $this->getKey()],
            ['password' => $password],
        );

        $this->setRelation( 'passwordRecord', $passwordRecord );
    }

    /**
     * Get the password used by the auth provider.
     */
    public function getAuthPassword(): string
    {
        $password = $this->passwordRecord()->value( 'password' );

        return is_string( $password ) ? $password : '';
    }

    /**
     * Determine whether this user can impersonate other users.
     */
    public function canImpersonate(): bool
    {
        return $this->can( RolePermissionConstants::USERS_EDIT );
    }

    /**
     * Determine whether this user can be impersonated.
     */
    public function canBeImpersonated(): bool
    {
        return ! $this->hasRole( RoleNameConstants::ADMIN );
    }

    /**
     * Scope a query to search by name or email.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeSearch( Builder $query, string $search ): Builder
    {
        if ( $search === '' ) {
            return $query;
        }

        return $query->where( function ( Builder $query ) use ( $search ): void {
            $query->where( 'name', 'like', '%' . $search . '%' )
                ->orWhere( 'email', 'like', '%' . $search . '%' );
        } );
    }

    /**
     * Get the indexable data array for Scout.
     *
     * @return array{id: string, name: string, email: string}
     */
    #[SearchUsingPrefix( ['id'] )]
    #[SearchUsingFullText( ['name', 'email'] )]
    public function toSearchableArray(): array
    {
        $key = $this->getKey();

        return [
            'id'    => is_int( $key ) || is_string( $key ) ? (string) $key : '',
            'name'  => (string) $this->name,
            'email' => (string) $this->email,
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
