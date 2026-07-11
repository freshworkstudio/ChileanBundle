<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle;

/**
 * Available output formats for a RUT.
 */
enum RutFormat: int
{
    /** Ex: 12.345.678-9 */
    case Complete = 0;

    /** Ex: 123456789 */
    case Escaped = 1;

    /** Ex: 12345678-9 */
    case WithDash = 2;
}
