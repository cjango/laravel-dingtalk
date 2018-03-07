<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) mingyoung <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyDingTalk\Kernel\Messages;

/**
 * Class Card.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Card extends Message
{
    protected $type = 'action_card';
}
