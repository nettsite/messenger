<?php

namespace NettSite\Messenger\Enums;

enum RegistrationMode: string
{
    case Open = 'open';
    case Approval = 'approval';
    case Closed = 'closed';
}
