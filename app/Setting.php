<?php

namespace App;


class Setting
{
    protected $allowedAttribute = [
        'city',
        'info'
    ];
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {

        $this->user = $user;
    }

    //
    public function merge(array $attributes)
    {
        $settings = $this->user->settings;

        if (!is_array($settings)) {
            $settings = [];
        }

        $settings = array_merge(
            $settings,
            array_only(
                $attributes,
                $this->allowedAttribute
            )
        );

        $this->user->update([
            'settings' => $settings,
        ]);
    }
}
