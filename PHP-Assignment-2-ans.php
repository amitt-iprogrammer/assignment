<?php

$flattened_json = '[ { "id": 8, "parent": 4, "name": "Food & Lifestyle" }, { "id": 2, "parent": 1, "name": "Mobile Phones" }, { "id": 1, "parent": 0, "name": "Electronics" }, { "id": 3, "parent": 1, "name": "Laptops" }, { "id": 5, "parent": 4, "name": "Fiction" }, { "id": 4, "parent": 0, "name": "Books" }, { "id": 6, "parent": 4, "name": "Non-fiction" }, { "id": 7, "parent": 1, "name": "Storage" } ]';

$tree = json_decode($flattened_json);

function ObjSort($a, $b)
{
    return strcmp($a->id, $b->id);
}

usort($tree, "ObjSort");

function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element->parent == $parentId) {
            $children = buildTree($elements, $element->id);
            if ($children) {
                $element->children = $children;
            }
            $branch[] = $element;
        }
    }
	
    return $branch;
}

$hierarchical_json = buildTree($tree);

echo json_encode($hierarchical_json);
