<?php

declare (strict_types=1);
namespace Rector\Renaming\ValueObject;

/**
 * @api
 */
final class RenameAttribute
{
    /**
     * @readonly
     */
    private string $oldAttribute;
    /**
     * @readonly
     */
    private string $newAttribute;
    public function __construct(string $oldAttribute, string $newAttribute)
    {
        $this->oldAttribute = $oldAttribute;
        $this->newAttribute = $newAttribute;
    }
    public function getOldAttribute() : string
    {
        return $this->oldAttribute;
    }
    public function getNewAttribute() : string
    {
        return $this->newAttribute;
    }
}
