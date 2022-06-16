<?php


namespace Administrator\ExampleFast\YieldStreamSocket;


use Administrator\ExampleFast\YieldSocket\SelectInter;

class Select implements SelectInter
{
    private $_length;

    private $_index = 0;

    private $_data = array();

    public function __construct($count)
    {
        if ($count >= static::Max_select) {
            $this->_length = static::Max_select;
        } else {
            $this->_length = $count;
        }
    }

    public function addItem(SelectItem $item)
    {
        if (count($this->_data) < $this->_length) {
            $this->_data[] = $item;
        }
    }

    public function addItemData(TcpConnection $item)
    {
        $this->_data[$item->connectKey]->add($item);
    }

    public function getItemInputData(TcpConnection $item)
    {
        return $this->_data[$item->connectKey]->getInput($item);
    }


    public function setItemInputData($item, $buffer)
    {
        $this->_data[$item->connectKey]->setInput($item, $buffer);
    }

    public function ClearItemInputData(TcpConnection $item)
    {
        $this->_data[$item->connectKey]->clearInput($item);
    }

    public function delItemData(TcpConnection $item)
    {
        $this->_data[$item->connectKey]->delete($item);
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    public function current()
    {
        return $this->_data[$this->_index];
    }

    public function getLength()
    {
        return $this->_length;
    }

    public function next()
    {
        if ($this->_index < $this->_length) {
            $this->_index++;
        } else {
            $this->_index = $this->_length;
        }
    }

    public function loop()
    {
        $this->_index++;
        if ($this->_index >= $this->_length) {
            $this->_index = 0;
        }
    }

    public function key()
    {
        $keys = array_keys($this->_data);
        return $keys[$this->_index];
    }

    public function valid()
    {
        if ($this->_index < $this->_length) {
            return true;
        }
        return false;
    }

    public function rewind()
    {
        $this->_index = 0;
    }



}