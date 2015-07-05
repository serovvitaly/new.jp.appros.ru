//<script>
Ext.define('App.tree.{{ $class_name }}', {
    extend: 'Ext.tree.Panel',
    constructor: function(config) {

        var me = this;

        Ext.apply(me, {
            rootVisible: false,
            storeClass: 'App.treestore.{{ $class_name }}'//,
            //store: null
        }, config);

        //if (!me.store) {
            me.store = Ext.create(me.storeClass);
        //}

        me.contextmenu = Ext.create('Ext.menu.Menu', {
            items: [{
                text: 'Добавить папку',
                handler: function(item, e){
                    //
                }
            },{
                text: 'Редактировать',
                handler: function(item, e){
                    var record = this.up('menu').record;
                    me.createEditWindow('Редактирование', record);
                }
            },{
                text: 'Удалить',
                handler: function(item, e){
                    var self = this;
                    Ext.MessageBox.confirm('Удаление', 'Будут удалены все связанные с записью данные. Продолжить?', function(btn, text){
                        if (btn == 'yes') {
                            me.getRootNode().removeChild(self.up('menu').record);
                        }
                    });
                }
            }]
        });

        this.callParent(arguments);
    },
    listeners: {
        cellcontextmenu: function(el, td, cellIndex, record, tr, rowIndex, e, eOpts){
            this.contextmenu.record = record;
            this.contextmenu.showAt(e.getXY());
            e.stopEvent();
        }
    }
});
