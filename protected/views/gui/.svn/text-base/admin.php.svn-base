<style>
    .x-row-red {
        background-color: #FFA0A2;
    }
    .x-row-green {
        background-color: #60BF60;
    }
</style>
<div id="preloader">Идет загрузка и запуск приложения. Пожалуйста, подождите...</div>
<script>
    var hdRevision = '<?=  CommonFunctions::getVersion(); ?>';
    var revNotified = 0;

Ext.require([
    'Ext.layout.*',
    'Ext.tab.Panel',
    'Ext.window.MessageBox',
    'Ext.window.Window',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.util.*',
    'Ext.state.*',
    'Ext.tree.*',
    'Ext.form.*',
    'Ext.JSON'
]);

function newRType() {
    var rtDialog = new Ext.create('Ext.window.Window', {
        title: 'Новый тип заявок',
        modal: true,
        width: 800,
        height: 100,
        layout: 'fit',
        items: [
            new Ext.create('Ext.form.Panel', {
                url: 'index.php?r=admin/creatertype',
                method: 'POST',
                frame: true,
                bodyStyle:'padding:5px 5px 0',
                fieldDefaults: {
                    msgTarget: 'side',
                    labelWidth: 150
                },
                defaultType: 'textfield',
                defaults: {
                    anchor: '100%'
                },
                items: [
                    {
                        xtype: 'hiddenfield',
                        name: 'parent_id',
                        value: Ext.getCmp('rttree').getSelectionModel().getSelection()[0].data.id
                    },
                    {
                        xtype: 'textfield',
                        name: 'name',
                        fieldLabel: 'Название типа',
                        allowBlank: false
                    }
                ],
                buttons: [
                    {
                        text: 'Создать',
                        handler: function() {
                            if (this.up('form').getForm().isValid()) {
                                this.up('form').getForm().submit({
                                    success: function(form, action) {
                                        rtDialog.hide();
                                        getRType(Ext.JSON.decode(action.response.responseText).id);
                                        Ext.getStore('tree').load();
                                    },
                                    failure: function() {
                                        Ext.MessageBox.alert('Ошибка', 'Не удалось выполнить операцию!');
                                    }
                                });
                            }
                        }
                    }
                ]
            })
        ]
    });
    rtDialog.show();
}

function getRType(id) {
    Ext.Ajax.request({
        url: 'index.php?r=admin/getrtype',
        params: {
            id: id
        },
        method: 'POST',
        success: function(res) {
            var data = Ext.JSON.decode(res.responseText);
            Ext.getCmp('rtId').setValue(data.id);
            Ext.getCmp('rtName').setValue(data.name);
            Ext.getCmp('rtNorm').setValue(data.norma);
            Ext.getCmp('rtComplex').setValue(data.complexity);
            Ext.getCmp('rtFull').select(data.group_full);
            Ext.getCmp('rtWork').select(data.group_work);
            Ext.getCmp('rtNotify').select(data.group_notify);
            Ext.getCmp('rtView').select(data.group_view);
        },
        failure: function() {
            Ext.MessageBox.alert('Ошибка', 'Не удалось загрузить данные!');
        }
    });
}

function newGroup() {
    var ngroupDialog = new Ext.create('Ext.window.Window', {
        title: 'Новая группа',
        modal: true,
        width: 800,
        height: 100,
        layout: 'fit',
        items: [
            new Ext.create('Ext.form.Panel', {
                url: 'index.php?r=admin/creategroup',
                method: 'POST',
                frame: true,
                bodyStyle:'padding:5px 5px 0',
                fieldDefaults: {
                    msgTarget: 'side',
                    labelWidth: 150
                },
                defaultType: 'textfield',
                defaults: {
                    anchor: '100%'
                },
                items: [
                    {
                        xtype: 'textfield',
                        name: 'groupname',
                        fieldLabel: 'Название группы',
                        allowBlank: false
                    }
                ],
                buttons: [
                    {
                        text: 'Создать группу',
                        handler: function() {
                            if (this.up('form').getForm().isValid()) {
                                this.up('form').getForm().submit({
                                    success: function(form, action) {
                                        ngroupDialog.hide();
                                        showGroup(Ext.JSON.decode(action.response.responseText).gid);
                                        Ext.getStore('groupstore').load();
                                    },
                                    failure: function() {
                                        Ext.MessageBox.alert('Ошибка', 'Не удалось выполнить операцию!');
                                    }
                                });
                            }
                        }
                    }
                ]
            })
        ]
    });
    ngroupDialog.show();
}

function showGroup(gid) {
    Ext.Ajax.request({
        url: 'index.php?r=admin/getgroup',
        params: {
            id: gid
        },
        success: function(response) {
            var data = Ext.JSON.decode(response.responseText);
            var groupDialog = Ext.create('Ext.window.Window', {
                title: data.groupname,
                modal: true,
                width: 800,
                height: 500,
                layout: 'fit',
                items: [
                    new Ext.create('Ext.form.Panel', {
                        url: 'index.php?r=admin/savegroup',
                        method: 'POST',
                        frame: true,
                        bodyStyle:'padding:5px 5px 0',
                        fieldDefaults: {
                            msgTarget: 'side',
                            labelWidth: 150
                        },
                        defaultType: 'textfield',
                        defaults: {
                            anchor: '100%'
                        },
                        items: [
                            {
                                xtype: 'hiddenfield',
                                name: 'id',
                                value: data.id
                            },
                            {
                                xtype: 'displayfield',
                                fieldLabel: 'Идентификатор',
                                value: data.id
                            },
                            {
                                xtype: 'textfield',
                                name:  'groupname',
                                fieldLabel: 'Имя группы',
                                value: data.groupname,
                                allowBlank: false
                            },
                            new Ext.create('Ext.grid.Panel', {
                                title: 'Члены группы',
                                height: '300',
                                store: new Ext.create('Ext.data.JsonStore', {
                                    storeId: 'ustore',
                                    proxy: {
                                        type: 'ajax',
                                        url: 'index.php?r=admin/groupusers',
                                        extraParams: {gid: data.id},
                                        reader: {
                                            type: 'json',
                                            root: 'items',
                                            totalProperty: 'totalCount'
                                        }
                                    },
                                    idIndex: 0,
                                    autoLoad: true,
                                    fields: ['uid', 'uname', 'ingroup']
                                }),
                                columns: [
                                    {
                                        text: 'Пользователь',
                                        dataIndex: 'uname',
                                        width: 400
                                    }
                                ],
                                scroll: false,
                                viewConfig: {
                                    style: {overflow: 'auto', overflowX: 'hidden'},
                                    stripeRows: false,
                                    getRowClass: function(record) {                
                                        if (record.data.ingroup == 1) {
                                            return 'x-row-green';
                                        } else {
                                            return "x-row-red";
                                        }
                                    }
                                },
                                listeners: {
                                    itemclick: {
                                        fn: function(view, record) {
                                            Ext.Ajax.request({
                                                method: 'POST',
                                                url: 'index.php?r=admin/chgroup',
                                                params: {
                                                    gid: data.id,
                                                    uid: record.data.uid
                                                },
                                                success: function() {
                                                    Ext.getStore('ustore').load();
                                                }
                                            });
                                        }
                                    }
                                }
                                
                            })
                        ],
                        buttons: [
                            {
                                text: 'Сохранить изменения',
                                handler: function() {
                                    if (this.up('form').getForm().isValid()) {
                                        this.up('form').getForm().submit({
                                            success: function() {
                                                groupDialog.hide();
                                                Ext.getStore('groupstore').load();
                                            },
                                            failure: function() {
                                                Ext.MessageBox.alert('Ошибка', 'Не удалось сохранить изменения!');
                                            }
                                        });
                                    }
                                }
                            }
                        ]
                    })
                ]
            });
            groupDialog.show();
        },
        failure: function() {
            Ext.MessageBox.alert('Ошибка', 'Не удалось получить данные о группе!');
        }
    });
};

function newUser() {
    var nuserDialog = new Ext.create('Ext.window.Window', {
        title: 'Новый пользователь',
        modal: true,
        width: 800,
        height: 300,
        layout: 'fit',
        items: [
            new Ext.create('Ext.form.Panel', {
                url: 'index.php?r=admin/createuser',
                method: 'POST',
                frame: true,
                bodyStyle:'padding:5px 5px 0',
                fieldDefaults: {
                    msgTarget: 'side',
                    labelWidth: 150
                },
                defaultType: 'textfield',
                defaults: {
                    anchor: '100%'
                },
                items: [
                    {
                        xtype: 'textfield',
                        name: 'login',
                        fieldLabel: 'Имя для входа',
                        allowBlank: false
                    },
                    {
                        xtype: 'textfield',
                        name: 'password',
                        inputType: 'password',
                        fieldLabel: 'Пароль',
                        allowBlank: false
                    },
                    {
                        name: 'number',
                        fieldLabel: 'Личный номер',
                        allowBlank: true
                    },
                    {
                        name: 'name',
                        fieldLabel: 'Полное имя',
                        allowBlank: false
                    },
                    {
                        name: 'position',
                        fieldLabel: 'Должность',
                        allowBlank: true
                    },
                    {
                        name: 'razr',
                        fieldLabel: 'Разряд',
                        allowBlank: true
                    },
                    {
                        name: 'email',
                        fieldLabel: 'Почта',
                        allowBlank: true
                    },
                    {
                        name: 'jabber',
                        fieldLabel: 'Jabber',
                        allowBlank: false
                    }
                ],
                buttons: [
                    {
                        text: 'Создать пользователя',
                        handler: function() {
                            if (this.up('form').getForm().isValid()) {
                                this.up('form').getForm().submit({
                                    success: function(form, action) {
                                        nuserDialog.hide();
                                        showUser(Ext.JSON.decode(action.response.responseText).uid);
                                        Ext.getStore('userstore').load();
                                    },
                                    failure: function() {
                                        Ext.MessageBox.alert('Ошибка', 'Не удалось выполнить операцию!');
                                    }
                                });
                            }
                        }
                    }
                ]
            })
        ]
    });
    nuserDialog.show();
}

function showUser(uid) {
    Ext.Ajax.request({
        url: 'index.php?r=admin/getuser',
        params: {
            id: uid
        },
        success: function(response) {
            var data = Ext.JSON.decode(response.responseText);
            var userDialog = Ext.create('Ext.window.Window', {
                title: data.name,
                modal: true,
                width: 800,
                height: 500,
                layout: 'fit',
                items: [
                    new Ext.create('Ext.form.Panel', {
                        url: 'index.php?r=admin/saveuser',
                        method: 'POST',
                        frame: true,
                        bodyStyle:'padding:5px 5px 0',
                        fieldDefaults: {
                            msgTarget: 'side',
                            labelWidth: 150
                        },
                        defaultType: 'textfield',
                        defaults: {
                            anchor: '100%'
                        },
                        items: [
                            {
                                xtype: 'hiddenfield',
                                name: 'id',
                                value: data.id
                            },
                            {
                                xtype: 'displayfield',
                                fieldLabel: 'Идентификатор',
                                value: data.id
                            },
                            {
                                xtype: 'textfield',
                                name:  'login',
                                fieldLabel: 'Имя для входа',
                                value: data.login,
                                allowBlank: false
                            },
                            {
                                xtype: 'textfield',
                                name:  'password',
                                fieldLabel: 'Новый пароль',
                                inputType: 'password',
                                allowBlank: true
                            },
                            {
                                xtype: 'checkboxfield',
                                name: 'changepass',
                                fieldLabel: 'Сменить пароль при входе'
                            },
                            {
                                name: 'number',
                                fieldLabel: 'Личный номер',
                                allowBlank: true,
                                value: data.number
                            },
                            {
                                xtype: 'textfield',
                                name: 'name',
                                fieldLabel: 'Полное имя',
                                value: data.name
                            },
                            {
                                xtype: 'textfield',
                                name: 'position',
                                fieldLabel: 'Должность',
                                value: data.position
                            },
                            {
                                name: 'razr',
                                fieldLabel: 'Разряд',
                                allowBlank: true,
                                value: data.razr
                            },
                            {
                                xtype: 'textfield',
                                name: 'email',
                                fieldLabel: 'Почта',
                                value: data.email
                            },
                            {
                                xtype: 'textfield',
                                name: 'jabber',
                                fieldLabel: 'Jabber',
                                value: data.jabber
                            },
                            new Ext.create('Ext.grid.Panel', {
                                title: 'Членство в группах',
                                height: '200',
                                store: new Ext.create('Ext.data.JsonStore', {
                                    storeId: 'gstore',
                                    proxy: {
                                        type: 'ajax',
                                        url: 'index.php?r=admin/usergroups',
                                        extraParams: {uid: data.id},
                                        reader: {
                                            type: 'json',
                                            root: 'items',
                                            totalProperty: 'totalCount'
                                        }
                                    },
                                    idIndex: 0,
                                    autoLoad: true,
                                    fields: ['gid', 'gname', 'ingroup']
                                }),
                                columns: [
                                    {
                                        text: 'Группа',
                                        dataIndex: 'gname',
                                        width: 400
                                    }
                                ],
                                scroll: false,
                                viewConfig: {
                                    style: {overflow: 'auto', overflowX: 'hidden'},
                                    stripeRows: false,
                                    getRowClass: function(record) {                
                                        if (record.data.ingroup == 1) {
                                            return 'x-row-green';
                                        } else {
                                            return "x-row-red";
                                        }
                                    }
                                },
                                listeners: {
                                    itemclick: {
                                        fn: function(view, record) {
                                            Ext.Ajax.request({
                                                method: 'POST',
                                                url: 'index.php?r=admin/chgroup',
                                                params: {
                                                    uid: data.id,
                                                    gid: record.data.gid
                                                },
                                                success: function() {
                                                    Ext.getStore('gstore').load();
                                                }
                                            });
                                        }
                                    }
                                }
                                
                            })
                        ],
                        buttons: [
                            {
                                text: 'Сохранить изменения',
                                handler: function() {
                                    if (this.up('form').getForm().isValid()) {
                                        this.up('form').getForm().submit({
                                            success: function() {
                                                userDialog.hide();
                                                Ext.getStore('userstore').load();
                                            },
                                            failure: function() {
                                                Ext.MessageBox.alert('Ошибка', 'Не удалось сохранить изменения!');
                                            }
                                        });
                                    }
                                }
                            }
                        ]
                    })
                ]
            });
            userDialog.show();
        },
        failure: function() {
            Ext.MessageBox.alert('Ошибка', 'Не удалось получить данные о пользователе!');
        }
    });
};

Ext.onReady(function() {
    Ext.create('Ext.container.Viewport', {
        layout: 'fit',
        items: {
            title: ' Управление Helpdesk (<?=Yii::app()->user->getId() . " :uid" . Yii::app()->user->uid ?>) сборка приложения: '+hdRevision,
            tools: [
                {
                    type: 'close',
                    tooltip: 'выйти из системы',
                    handler: function() {
                        document.location = "index.php?r=site/logout";
                    }
                }
            ],
            layout: 'border',
            defaults: {
                collapsible: false,
                split: true,
                resizable: false
            },
            items: [
                {
                    region: 'center',
                    xtype: 'tabpanel',
                    items: [
                        {
                            title: 'Пользователи',
                            layout: 'fit',
                            items: [
                                {
                                    layout: 'border',
                                    items: [
                                        {
                                            region: 'north',
                                            height: 35,
                                            items: [
                                                new Ext.create('Ext.Button', {
                                                    margin: 5,
                                                    text: 'Новый пользователь',
                                                    handler: function() {
                                                        newUser();
                                                    }
                                                })
                                            ]
                                        }, 
                                        {
                                            region: 'center',
                                            layout: 'fit',
                                            items: [
                                                new Ext.create('Ext.grid.Panel', {
                                                    forceFit: true,
                                                    store: new Ext.create('Ext.data.JsonStore', {
                                                        storeId: 'userstore',
                                                        proxy: {
                                                            type: 'ajax',
                                                            url: 'index.php?r=admin/users',
                                                            reader: {
                                                                type: 'json',
                                                                root: 'items',
                                                                totalProperty: 'totalCount'
                                                            }
                                                        },
                                                        idIndex: 0,
                                                        autoLoad: true,
                                                        fields: ['id', 'login', 'name', 'email', 'jabber', 'locked']
                                                    }),
                                                    columns: [
                                                        {
                                                            text: 'uid',
                                                            dataIndex: 'id',
                                                            width: 50
                                                        },
                                                        {
                                                            text: 'login',
                                                            dataIndex: 'login',
                                                            width: 200
                                                        },
                                                        {
                                                            text: 'Полное имя',
                                                            dataIndex: 'name',
                                                            width: 400
                                                        },
                                                        {
                                                            text: 'jabber',
                                                            dataIndex: 'jabber',
                                                            width: 300
                                                        }
                                                    ],
                                                    listeners: {
                                                        itemclick: {
                                                            fn: function(view, record) {
                                                                showUser(record.data.id);
                                                            }
                                                        }
                                                    },
                                                    scroll: false,
                                                    viewConfig: {
                                                        style: {overflow: 'auto', overflowX: 'hidden'},
                                                        stripeRows: true
                                                    }
                                                })
                                            ]
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            title: 'Группы',
                            layout: 'fit',
                            items: [
                                {
                                    layout: 'border',
                                    items: [
                                        {
                                            region: 'north',
                                            height: 35,
                                            items: [
                                                new Ext.create('Ext.Button', {
                                                    margin: 5,
                                                    text: 'Новая группа',
                                                    handler: function() {
                                                        newGroup();
                                                    }
                                                })
                                            ]
                                        }, 
                                        {
                                            region: 'center',
                                            layout: 'fit',
                                            items: [
                                                new Ext.create('Ext.grid.Panel', {
                                                    forceFit: true,
                                                    store: new Ext.create('Ext.data.JsonStore', {
                                                        storeId: 'groupstore',
                                                        proxy: {
                                                            type: 'ajax',
                                                            url: 'index.php?r=admin/groups',
                                                            reader: {
                                                                type: 'json',
                                                                root: 'items',
                                                                totalProperty: 'totalCount'
                                                            }
                                                        },
                                                        idIndex: 0,
                                                        autoLoad: true,
                                                        fields: ['id', 'groupname']
                                                    }),
                                                    columns: [
                                                        {
                                                            text: 'gid',
                                                            dataIndex: 'id',
                                                            width: 50
                                                        },
                                                        {
                                                            text: 'Имя группы',
                                                            dataIndex: 'groupname',
                                                            width: 400
                                                        }
                                                    ],
                                                    listeners: {
                                                        itemclick: {
                                                            fn: function(view, record) {
                                                                showGroup(record.data.id);
                                                            }
                                                        }
                                                    },
                                                    scroll: false,
                                                    viewConfig: {
                                                        style: {overflow: 'auto', overflowX: 'hidden'},
                                                        stripeRows: true
                                                    }
                                                })
                                            ]
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            title: 'Типы заявок',
                            layout: 'border',
                            items: [
                                {
                                    region: 'west',
                                    layout: 'fit',
                                    width: 400,
                                    title: 'Дерево типов',
                                    tools: [
                                        {
                                            type: 'plus',
                                            toolTip: 'Новый тип',
                                            handler: function() {
                                                newRType();
                                            }
                                        }
                                    ],
                                    items: [
                                        new Ext.tree.TreePanel({
                                            id: 'rttree',
                                            store: new Ext.create("Ext.data.TreeStore", {
                                                storeId: 'tree',
                                                proxy: {
                                                    type: 'ajax',
                                                    url: 'index.php?r=admin/rtypes'
                                                },
                                                autoLoad: true,
                                                root: {
                                                    expanded: true,
                                                    id: null,
                                                    text: 'Все типы'
                                                }
                                            }),
                                            rootVisible: true,
                                            viewConfig: {
                                                plugins: {
                                                    ptype: 'treeviewdragdrop',
                                                    appendOnly: true
                                                    
                                                },
                                                listeners: {
                                                        drop: function(node, data, over) {   
                                                            var item = data.records[0].data.id;
                                                            var parent = over.data.id;
                                                            var ask = new Ext.create('Ext.window.Window', {
                                                                title: 'Подтверждение',
                                                                width: 400,
                                                                height: 100,
                                                                layout: 'fit',
                                                                items: [
                                                                    new Ext.create('Ext.form.Panel', {
                                                                        url: 'index.php?r=request/create',
                                                                        method: 'POST',
                                                                        frame: true,
                                                                        bodyStyle:'padding:5px 5px 0',
                                                                        fieldDefaults: {
                                                                            msgTarget: 'side',
                                                                            labelWidth: 100
                                                                        },
                                                                        defaults: {
                                                                            anchor: '100%'
                                                                        },
                                                                        items: [
                                                                            {
                                                                                xtype: 'displayfield',
                                                                                value: 'Подтвердите перенос'
                                                                            }
                                                                        ],
                                                                        buttons: [
                                                                            {
                                                                                text: 'Да',
                                                                                handler: function() {
                                                                                    ask.hide();
                                                                                    Ext.Ajax.request({
                                                                                        url: 'index.php?r=admin/movert',
                                                                                        method: 'POST',
                                                                                        params: {
                                                                                            id: item,
                                                                                            parent: parent
                                                                                        },
                                                                                        failure: function() {
                                                                                            Ext.MessageBox.alert('Ошибка', 'Не удалось выполнить операцию!');
                                                                                            Ext.getStore('tree').load();
                                                                                        }
                                                                                    });
                                                                                }
                                                                            },
                                                                            {
                                                                                text: 'Нет',
                                                                                handler: function() {
                                                                                    ask.hide();
                                                                                    Ext.getStore('tree').load();
                                                                                }
                                                                            }
                                                                        ]
                                                                    })
                                                                ]
                                                            });
                                                            ask.show();
                                                        }
                                                    }
                                            },
                                            listeners: {
                                                itemclick: {
                                                    fn: function(y,r) {
                                                        if (r.data.id != null) {
                                                            getRType(r.data.id);
                                                        }
                                                    }
                                                }
                                                
                                            }
                                        })
                                    ]
                                },
                                {
                                    region: 'center',
                                    layout: 'fit',
                                    items: [
                                        new Ext.create('Ext.form.Panel', {
                                            url: 'index.php?r=admin/savertype',
                                            method: 'POST',
                                            frame: true,
                                            bodyStyle:'padding:5px 5px 0',
                                            fieldDefaults: {
                                                msgTarget: 'side',
                                                labelWidth: 100
                                            },
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%'
                                            },
                                            items: [
                                                {
                                                    id: 'rtId',
                                                    name: 'id',
                                                    xtype: 'hiddenfield'
                                                },
                                                {
                                                    id: 'rtName',
                                                    name: 'name',
                                                    fieldLabel: 'Название'
                                                },
                                                {
                                                    id: 'rtNorm',
                                                    name: 'norma',
                                                    fieldLabel: 'Норма времени'
                                                },
                                                {
                                                    id: 'rtComplex',
                                                    name: 'complexity',
                                                    fieldLabel: 'Сложность'
                                                },
                                                {
                                                    xtype: 'fieldset',
                                                    title: 'Группы доступа',
                                                    columnWidth: 1,
                                                    collapsible: false,
                                                    defaultType: 'textfield',
                                                    defaults: {anchor: '100%'},
                                                    layout: 'anchor',
                                                    items:[
                                                        new Ext.create('Ext.form.ComboBox', {
                                                            fieldLabel: 'Полный доступ',
                                                            id: 'rtFull',
                                                            name: 'group_full',
                                                            displayField: 'groupname',
                                                            valueField: 'id',
                                                            store: new Ext.create('Ext.data.JsonStore', {
                                                                storeId: 'full',
                                                                fields: ['id', 'groupname'],
                                                                proxy: {
                                                                    type: 'ajax',
                                                                    url: 'index.php?r=admin/groups',
                                                                    autoLoad: true,
                                                                    reader: {
                                                                        type: 'json',
                                                                        root: 'items',
                                                                        totalProperty: 'totalCount'
                                                                    }
                                                                }
                                                            })
                                                        }),
                                                        new Ext.create('Ext.form.ComboBox', {
                                                            fieldLabel: 'Исполнители',
                                                            id: 'rtWork',
                                                            name: 'group_work',
                                                            displayField: 'groupname',
                                                            valueField: 'id',
                                                            store: new Ext.create('Ext.data.JsonStore', {
                                                                storeId: 'work',
                                                                fields: ['id', 'groupname'],
                                                                proxy: {
                                                                    type: 'ajax',
                                                                    url: 'index.php?r=admin/groups',
                                                                    autoLoad: true,
                                                                    reader: {
                                                                        type: 'json',
                                                                        root: 'items',
                                                                        totalProperty: 'totalCount'
                                                                    }
                                                                }
                                                            })
                                                        }),
                                                        new Ext.create('Ext.form.ComboBox', {
                                                            fieldLabel: 'Уведомления',
                                                            id: 'rtNotify',
                                                            name: 'group_notify',
                                                            displayField: 'groupname',
                                                            valueField: 'id',
                                                            store: new Ext.create('Ext.data.JsonStore', {
                                                                storeId: 'notify',
                                                                fields: ['id', 'groupname'],
                                                                proxy: {
                                                                    type: 'ajax',
                                                                    url: 'index.php?r=admin/groups',
                                                                    autoLoad: true,
                                                                    reader: {
                                                                        type: 'json',
                                                                        root: 'items',
                                                                        totalProperty: 'totalCount'
                                                                    }
                                                                }
                                                            })
                                                        }),
                                                        new Ext.create('Ext.form.ComboBox', {
                                                            fieldLabel: 'Просмотр',
                                                            id: 'rtView',
                                                            name: 'group_view',
                                                            displayField: 'groupname',
                                                            valueField: 'id',
                                                            store: new Ext.create('Ext.data.JsonStore', {
                                                                storeId: 'view',
                                                                fields: ['id', 'groupname'],
                                                                proxy: {
                                                                    type: 'ajax',
                                                                    url: 'index.php?r=admin/groups',
                                                                    autoLoad: true,
                                                                    reader: {
                                                                        type: 'json',
                                                                        root: 'items',
                                                                        totalProperty: 'totalCount'
                                                                    }
                                                                }
                                                            })
                                                        })
                                                    ]
                                                }

                                            ],
                                            buttons: [
                                                {
                                                    text: 'Сохранить',
                                                    handler: function() {
                                                        if (this.up('form').getForm().isValid()) {
                                                            this.up('form').getForm().submit({
                                                                success: function() {
                                                                    Ext.getStore('tree').load();
                                                                    Ext.MessageBox.alert('Сохранение', 'Данные сохранены');
                                                                },
                                                                failure: function() {
                                                                    Ext.MessageBox.alert('Ошибка', 'Не удалось сохранить данные!');
                                                                }
                                                            });
                                                        }
                                                    }
                                                }
                                            ]
                                        })
                                    ]
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    });
    
    
Ext.getStore('full').load();
Ext.getStore('work').load();
Ext.getStore('notify').load();
Ext.getStore('view').load();

/*    Ext.TaskManager.start({
        run: function() {

        },
        interval: 30000
    }); */
    document.getElementById('preloader').style.display = "none";
})

</script>