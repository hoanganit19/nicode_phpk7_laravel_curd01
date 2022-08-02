<?php
function isSelected($fieldName, $currentId, $id){
    if (old($fieldName)){
        if (old($fieldName)==$id){
            return 'selected';
        }
    }else{
        if ($currentId==$id){
            return 'selected';
        }
    }
}
