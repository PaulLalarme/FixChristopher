<?php

declare (strict_types = 1);

 namespace App\Enum;

 enum Priority : string {
    case LOW = "faible";
    case MEDIUM = "moyenne";

    case HIGH = "absolue";

    public function badgeClass(): string{
        return match ($this){

            self::HIGH => 'text-bg-danger',
            self::MEDIUM => 'text-bg-warning',
            self::LOW => 'text-bg-primary',


        };
    }
 }
