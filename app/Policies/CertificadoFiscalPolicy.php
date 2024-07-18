<?php

namespace App\Policies;

use App\Models\CertificadoFiscal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CertificadoFiscalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CertificadoFiscal $certificadoFiscal): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CertificadoFiscal $certificadoFiscal): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CertificadoFiscal $certificadoFiscal): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CertificadoFiscal $certificadoFiscal): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CertificadoFiscal $certificadoFiscal): bool
    {
        //
    }
}
