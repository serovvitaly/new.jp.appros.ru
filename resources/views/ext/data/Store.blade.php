//<script>
Ext.define('App.store.{{ $model_name }}', {
    extend: 'Ext.data.Store',
    storeId: 'store{{ $model_name }}',
    autoLoad: true,
    autoSync: true,
    model: 'App.model.{{ $model_name }}',
    proxy: Ext.create('App.common.proxies.RestProxy', {url: '/rest/{{ strtolower($model_name) }}'}),
    listeners: {
        write: function(store, operation, eOpts){
            this.load();
        }
    }
});