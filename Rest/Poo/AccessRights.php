<?php
/*
enum AccessRights: string
{
    case PUBLIC_ACCESS = 'PUBLIC_ACCESS';
    case SAME_USER = 'SAME_USER';
    case GROUP_MEMBERS = 'GROUP_MEMBERS';
    case GAME_MASTER = 'GAME_MASTER';
    case ADMIN = 'ADMIN';
    // etc.
}
*/
abstract class AccessRights
{
    const PUBLIC_ACCESS = 'ALL_ACCESS';
    const SAME_USER = 'SAME_USER';
    const GROUP_MEMBERS = 'GROUP_MEMBERS';
    const GAME_MASTER = 'GAME_MASTER';
    const ADMIN = 'ADMIN';
    // etc.
}

?>