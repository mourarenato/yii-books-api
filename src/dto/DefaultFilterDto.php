<?php

namespace app\dto;

class DefaultFilterDto
{
    public int $limit;
    public int $offset;
    public ?string $order = null;
    public ?string $filter = null;
}