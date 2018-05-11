<?php
namespace jtgc\parser;

use jtg;
use gui;
use php\io\File;
use php\lib\fs;

class JTGC 
{
    private $components;
    private $guiArray;
    
    public function __construct(File $file)
    {
        $this->guiArray = fs::parse($file, "json");
        $this->components = [
            "button" => UXButton::class,
            "panel"  => UXPanel::class,
            "imageView" => UXImageView::class,
            "image" => UXImage::class,
            "label" => UXLable::class,
            "flatButton" => UXFlatButton::class,
        ];
    }
    
    /**
     * @return UXAnchorPane
     */
    public function get(array $size) : UXAnchorPane
    {
        $panel = new UXAnchorPane;
        $panel->size = $size;
        
        foreach ($this->guiArray as $nodeData)
        {
            $panel->add($this->parseNode($nodeData));
        }
        
        return $panel;
    }
    
    /**
     * @return UXNode
     */
    private function parseNode(array $data)
    {
        if ($data['__']) $node = new $this->components[$data['_']]($data['__']);
        else             $node = new $this->components[$data['_']];
        foreach ($data as $key => $val)
        {
            if ($key == "_") continue;  // node class
            if ($key == "__") continue; // node constructor
            
            if ($key == "content" && $this->isJTGNode($val))
            {
                if ($node instanceof UXPanel)
                    $node->add($this->parseNode($val));
                else throw new JTGCError("Unable to add objects not in UXPanel");
            } elseif ($key == "graphic" && $this->isJTGNode($val)) {
                $node->graphic = $this->parseNode($val);
            } elseif ($key == "image" && $this->isJTGNode($val)) {
                if ($node instanceof UXImageView)
                    $node->image = $this->parseNode($val);
                else throw new JTGCError("Unable to add image not in UXImageView");
            } else {
                $node->{$key} = $val;
            }
        }
        return $node;
    }
    
    /**
     * @return bool 
     */
    private function isJTGNode($val)
    {
        return (is_array($val) && $val['_']);
    }
}
