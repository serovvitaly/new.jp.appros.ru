//<script>
Ext.define('App.treestore.{{ $model_name }}', {
    extend: 'Ext.data.TreeStore',
    storeId:'treestore{{ $model_name }}',
    autoLoad: true,
    autoSync: true,
    model: 'App.treemodel.{{ $model_name }}',
    proxy: Ext.create('App.common.proxies.RestProxy', {url: '/rest/{{ strtolower($model_name) }}'}),
    listeners: {
        write: function(store, operation, eOpts){
            this.load();
        }
    }
});