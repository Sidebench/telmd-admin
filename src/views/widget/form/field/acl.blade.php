<div id="acl_tree" class=""></div>
<textarea style="display:none;" id="acl_tree_input" name="{{ $name }}">{{ json_encode($value ?: []) }}</textarea>
<script type="text/javascript">
$(function() {
    var tree = $('#acl_tree');
    var defaultData = {!! $source->getOptionsTreeData($value) !!};
    var input = $('#acl_tree_input');

    var aclTree = tree.treeview({
        expandIcon: "fa fa-plus",
        collapseIcon: "fa fa-minus",
        levels: 1,
        multiSelect: true,
        data: defaultData,
    });
    aclTree.on('nodeSelected', function(e, node){
        var value = JSON.parse(input.val());
        value.push(node.id);
        input.val(JSON.stringify(value));
        if(typeof node['nodes'] != "undefined") {
            var children = node['nodes'];
            for(var i = 0; i < children.length; i++) {
                aclTree.treeview('selectNode', [children[i].nodeId, {silent: true}]);
                aclTree.treeview('revealNode', [children[i].nodeId, {silent: true} ]);
                aclTree.trigger('nodeSelected', children[i]);
            }
        }
    });
    aclTree.on('nodeUnselected', function(e, node){
        var value = JSON.parse(input.val());
        value.splice(value.indexOf(node.id), 1);
        input.val(JSON.stringify(value));
        if(typeof node['nodes'] != "undefined") {
            var children = node['nodes'];
            for(var i = 0; i < children.length; i++) {
                aclTree.treeview('unselectNode', [children[i].nodeId, {silent: true}]);
                aclTree.trigger('nodeUnselected', children[i]);
            }
        }
    });
});
</script>