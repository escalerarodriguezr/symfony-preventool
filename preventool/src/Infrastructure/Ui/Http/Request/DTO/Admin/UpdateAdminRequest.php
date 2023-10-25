<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Admin;

use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAdminRequest implements RequestDTO
{
    const NAME = 'name';
    const LAST_NAME = 'lastName';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const ROLE = 'role';


    const ROLE_CHOICES = [
        AdminRole::ADMIN_ROLE_ROOT,
        AdminRole::ADMIN_ROLE_ADMIN
    ];

    /**
     * @Assert\NotBlank(allowNull = true)
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'name'."
     * )
     */
    private mixed $name;

    /**
     * @Assert\NotBlank(allowNull = true)
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'lastName'."
     * )
     */
    private mixed $lastName;

    /**
     * @Assert\NotBlank(allowNull = true)
     * @Assert\Email(
     *     message = "The email {{ value }} is not a valid email."
     * )
     */
    private mixed $email;



    /**
     * @Assert\NotBlank(allowNull = true)
     * @Assert\Choice(choices=self::ROLE_CHOICES, message="Choose a valid role.")
     */
    private mixed $role;



    public function __construct(Request $request)
    {
        $payLoad = $request->toArray();

        $this->name = $payLoad[self::NAME] ?? null;
        $this->lastName = $payLoad[self::LAST_NAME] ?? null;
        $this->email = $payLoad[self::EMAIL] ?? null;
        $this->role = $payLoad[self::ROLE] ?? null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }
}