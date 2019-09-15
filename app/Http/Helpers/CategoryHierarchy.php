<?php

namespace App\Helpers;

/**
 * Class TaskHierarchy
 */
class TaskHierarchy {

    /**
     * @var $items
     * @private
     */
    private $items;

    
    /**
     * @param array $items Collection of items that a hierarchical list will be generated for.
     */
    public function setupItems($items)
    {
        $this->items = $items;
    }

    /**
     * Generate the HTML list from an array of hierarchical data.
     *
     * @return string
     * @public
     */
    public function render()
    {
        // dd( $this->createItemArray() );
        return $this->htmlFromArray($this->createItemArray());
    }


    public function sumOfChildrenPoints($items){
        $total = 0;
        foreach ($items as $item) {
            $total += $item['total_points'];
        }
        return $total;
    }

    public function getStatusFromChildren($items)
    {
        $status = 1;
        foreach ($items as $item) {
            if($item['status'] == 0){
                $status = $item['status'];
                break;
            }           
        }

        return $status;
    }

    /**
     * Convert a collection of data with parent_id / id data into
     * a nested array that allows for easy traversal and list
     * production.
     *
     * @return array $result The nested array of data.
     */
    private function createItemArray()
    {
        $result = array();
        foreach($this->items as $item) {
            if ($item->parent_id == null) {
                $newItem = array();
                $newItem['title'] = $item->title;
                $newItem['children'] = $this->itemWithChildren($item);
                $newItem['parent_id'] = $item->parent_id;
                $newItem['user_id'] = $item->user_id;
                $newItem['points'] = $item->points;
                $newItem['is_done'] = $item->is_done;
                $newItem['id'] = $item->id;

                $newItem['status'] = empty($newItem['children']) ?  $item->is_done : $this->getStatusFromChildren($newItem['children']);
                $newItem['total_points'] = empty($newItem['children']) ?  $item->points : $this->sumOfChildrenPoints($newItem['children']);
                array_push($result, $newItem);
            }
        }
        return $result;
    }

    /**
     * Find the individual child nodes item has. From the example documentation,
     * if the $item passed to this method was 'Italian', the result from this
     * would assign a 'Pasta' and 'Pizza' node to the $result array.
     *
     * @param array $item The item for which children will be found.
     * @return array $result
     */
    private function childrenOf($item) {
        $result = array();
        foreach($this->items as $i) {
            if ($i->parent_id == $item->id) {
                $result[] = $i;
            }
        }
        return $result;
    }

    /**
     * Build an array of child nodes that are nested to given item.
     * (I.e.any elements that have a parent_id of the item that
     * is passed into the method).
     *
     * @param array $item
     * @return array $result
     */
    private function itemWithChildren($item) {
        $result = array();
        $children = $this->childrenOf($item);
        foreach ($children as $child) {
            $newItem = array();
            $newItem['title'] = $child->title;
            $newItem['children'] = $this->itemWithChildren($child);
            $newItem['parent_id'] = $child->parent_id;
            $newItem['user_id'] = $child->user_id;
            $newItem['points'] = $child->points;
            $newItem['is_done'] = $child->is_done;
            $newItem['id'] = $child->id;

            $newItem['status'] = empty($newItem['children']) ?  $child->is_done : $this->getStatusFromChildren($newItem['children']);
            $newItem['total_points'] = empty($newItem['children']) ?  $child->points : $this->sumOfChildrenPoints($newItem['children']);
            array_push($result, $newItem);
        }
        return $result;
    }

    /**
     * Generate the HTML list (<ul>) representation of the hierarchical array.
     *
     * @param array $hierarchicalArray
     * @param bool $addCheckboxes Should we append checkboxes to the list items?
     * @param string $listClass We can append classes to the <ul> tags
     * @return string $html
     */
    private function htmlFromArray($hierarchicalArray) {
        $html = '';
        foreach($hierarchicalArray as $item) {
            $html .= "<ul>";
            $html .= "<li style='color: ". ( ($item['status'] == 1) ? "green" : "red" ) ."'>". $item['title'] .  "<span style='color:black;'> --- ". $item['total_points'] ."</span></li>";
            if(count($item['children']) > 0) {
                $html .= $this->htmlFromArray($item['children']);
            }
            $html .= "</ul>";
        }
        return $html;
    }

}