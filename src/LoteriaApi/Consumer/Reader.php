<?php

namespace LoteriaApi\Consumer;

use \DOMDocument;
use LoteriaApi\Consumer\Reader\LoteriaNumbersNode;

class Reader
{
    private $datasource;
    private $paths;

    public function setDataSource($datasource)
    {
        $this->datasource = $datasource;
        return $this;
    }
    
    public function setPathsStorage($paths)
    {
        $this->paths = $paths;
        return $this;
    }
    
    public function getData()
    {
        $data = [];

        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        foreach ($this->datasource as $concursoName => $concursoData) {
            
            echo "[{$concursoData['name']}] - reading HTML file | ";
            
            $file = $this->paths['path']['ext'].$concursoData['html'];
            $doc = new DOMDocument();
            $doc->loadHTMLFile($file);
            $data[$concursoName] = (new $concursoData['reader'])
                ->setDOMDocument($doc)
                ->setNumbersNode(new LoteriaNumbersNode)
                ->getData();
        }

        // Restore error level
        libxml_use_internal_errors($internalErrors);
        return $data;
    }

    public function getDataLive()
    {
        $data = [];

        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        foreach ($this->datasource as $concursoName => $concursoData) {
            $file = $this->paths['path']['ext'].$concursoData['html'];
            $doc = new DOMDocument();
            $doc->loadHTMLFile($file);
            $data[$concursoName] = (new $concursoData['reader'])
                ->setDOMDocument($doc)
                ->setNumbersNode(new LoteriaNumbersNode)
                ->getDataLive();
        }

        // Restore error level
        libxml_use_internal_errors($internalErrors);

        return $data;
    }
}
