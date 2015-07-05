//<script>
Ext.define('App.model.{{ $model_name }}', {
    extend: 'Ext.data.Model',
    entityName: 'model{{ $model_name }}',
    fields: [{!! $fields !!}],
    proxy: Ext.create('App.common.proxies.RestProxy', {url: '/rest/{{ strtolower($model_name) }}'})
});