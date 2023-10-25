<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Admin;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAdminPasswordRequest implements RequestDTO
{
    const CURRENT_PASSWORD = 'currentPassword';
    const PASSWORD = 'password';



    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'password'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'currentPassword'."
     * )
     */
    private mixed $currentPassword;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'password'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'password'."
     * )
     */
    private mixed $password;


    public function __construct(Request $request)
    {
        $payLoad = $request->toArray();

        $this->password = $payLoad[self::PASSWORD] ?? null;
        $this->currentPassword = $payLoad[self::CURRENT_PASSWORD] ?? null;

    }

    public function getCurrentPassword():string
    {
        return $this->currentPassword;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}