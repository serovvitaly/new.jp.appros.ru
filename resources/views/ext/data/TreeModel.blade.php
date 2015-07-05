//<script>
Ext.define('App.treemodel.{{ $model_name }}', {
    extend: 'Ext.data.TreeModel',
    entityName: 'treemodel{{ $model_name }}',
    fields: {!! $fields !!},
    proxy: Ext.create('App.common.proxies.RestProxy', {url: '/rest/{{ strtolower($model_name) }}'})
});