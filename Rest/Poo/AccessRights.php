<?php

enum AccessRights: string
{
    case PUBLIC_ACCESS = 'PUBLIC_ACCESS';
    case SAME_USER = 'SAME_USER';
    case GROUP_MEMBERS = 'GROUP_MEMBERS';
    case GAME_MASTER = 'GAME_MASTER';
    case ADMIN = 'ADMIN';
    // etc.
}

?>