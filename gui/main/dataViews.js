function gridsRefresh() {
    console.log('reloading data for grids');
    Ext.getStore('busy').load();
    Ext.getStore('my').load();
    Ext.getStore('open').load();
    Ext.getStore('work').load();
    Ext.getStore('complete').load();
}

function getBusyGrid() {
    console.log('creting BUSY grid');
    var storeBusy = Ext.create('Ext.data.JsonStore', {
        storeId: 'busy',
        proxy: {
            type: 'ajax',
            url: 'index.php?r=stat/busy',
            reader: {
                type: 'json',
                root: 'items',
                totalProperty: 'totalCount'
            }
        },
        idIndex: 0,
        autoLoad: true,
        fields: [
            'id', 'name', 'status', 'rcount', 'active'
        ]
    });
    var gridBusy = Ext.create('Ext.grid.Panel', {
        store: storeBusy,
        forceFit: true,
        columns: [
            {
                text: 'Сотрудник',
                dataIndex: 'name',
                width: 300
            },
            {
                text: 'Статус',
                dataIndex: 'status',
                width: 100
            },
            {
                text: 'Заявки',
                dataIndex: 'rcount',
                width: 100
            }
        ],
        scroll: false,
        viewConfig: {
            stripeRows: false,
            style: {overflow: 'auto', overflowX: 'hidden'},
            getRowClass: function(record) {
                if (record.data.active == 0) {
                    return 'x-row-grey';
                } else
                if (record.data.rcount == 0) {
                    return 'x-row-green';
                } else if (record.data.rcount > 1 ){
                    return "x-row-red";
                } else {
                    return "x-row-yellow"
                }
            } 
        }
    });
    return gridBusy;
}


function getMyGrid() {
    console.log('creating MY grid');
    var storeMy = Ext.create('Ext.data.JsonStore', {
        storeId: 'my',
        proxy: {
            type: 'ajax',
            url: 'index.php?r=request/my',
            reader: {
                type: 'json',
                root: 'items',
                totalProperty: 'totalCount'
            }
        },
        idIndex: 0,
        autoLoad: true,
        fields: [
            'id', 'regtime', 'department','position','phone','fio','pc','ip',
            'description','closed','utime','uuser','rtype','rtype_id',
            'group_full','group_work','group_view', 'deadline'
        ]
    });
    var gridMy = Ext.create('Ext.grid.Panel', {
        store: storeMy,
        forceFit: true,
        columns: [
            {
                text: '№',
                sortable: true,
                dataIndex: 'id',
                resizable: false,
                width: 40
            },
            {
                text: 'Открыта',
                sortable: true,
                resizable: false,
                dataIndex: 'regtime',
                width: 100
            },
            {
                text: 'Подразделение',
                sortable: true,
                dataIndex: 'department',
                width: 200
            },
            {
                text: 'Пользователь',
                sortable: true,
                dataIndex: 'fio',
                width: 120
            },
            {
                text: 'Телефон',
                dataIndex: 'phone',
                width: 120
            },
            {
                text: 'Компьютер',
                dataIndex: 'pc',
                width: 120
            },
            {
                text: 'Тип заявки',
                sortable: true,
                dataIndex: 'rtype',
                width: 200
            }
        ],
        scroll: false,
        viewConfig: {
            style: {overflow: 'auto', overflowX: 'hidden'},
            stripeRows: true,
            getRowClass: function(record) {                
                if (record.data.deadline == 1) {
                    return 'x-row-deadline';
                } else {
                    return "";
                }
            } 
        }
    });
    gridMy.on('itemclick', function(y, r) {
        showRequestDetails(r.data.id)
    });
    return gridMy;
}

function getOpenGrid() {
    console.log('creating OPEN grid');
    var storeOpen = Ext.create('Ext.data.JsonStore', {
        storeId: 'open',
        proxy: {
            type: 'ajax',
            url: 'index.php?r=request/open',
            reader: {
                type: 'json',
                root: 'items',
                totalProperty: 'totalCount'
            }
        },
        idIndex: 0,
        autoLoad: true,
        fields: [
            'id', 'regtime', 'department','position','phone','fio','pc','ip',
            'description','closed','utime','uuser','rtype','rtype_id',
            'group_full','group_work','group_view', 'deadline'
        ]
    });
    var gridOpen = Ext.create('Ext.grid.Panel', {
        store: storeOpen,
        forceFit: true,
        columns: [
            {
                text: '№',
                sortable: true,
                dataIndex: 'id',
                resizable: false,
                width: 40
            },
            {
                text: 'Открыта',
                sortable: true,
                resizable: false,
                dataIndex: 'regtime',
                width: 100
            },
            {
                text: 'Подразделение',
                sortable: true,
                dataIndex: 'department',
                width: 200
            },
            {
                text: 'Пользователь',
                sortable: true,
                dataIndex: 'fio',
                width: 120
            },
            {
                text: 'Телефон',
                dataIndex: 'phone',
                width: 120
            },
            {
                text: 'Компьютер',
                dataIndex: 'pc',
                width: 120
            },
            {
                text: 'Тип заявки',
                sortable: true,
                dataIndex: 'rtype',
                width: 200
            }
        ],
        scroll: false,
        viewConfig: {
            style: {overflow: 'auto', overflowX: 'hidden'},
            stripeRows: true,
            getRowClass: function(record) {
                if (record.data.deadline == 1) {
                    return 'x-row-deadline';
                } else {
                    return "";
                }
            } 
        }
    });
    gridOpen.on('itemclick', function(y, r) {
        showRequestDetails(r.data.id)
    });
    return gridOpen;
}

function getWorkGrid() {
    console.log('creating WORK grid');
    var storeWork = Ext.create('Ext.data.JsonStore', {
        storeId: 'work',
        proxy: {
            type: 'ajax',
            url: 'index.php?r=request/work',
            reader: {
                type: 'json',
                root: 'items',
                totalProperty: 'totalCount'
            }
        },
        idIndex: 0,
        autoLoad: true,
        fields: [
            'id', 'regtime', 'department','position','phone','fio','pc','ip',
            'description','closed','utime','uuser','rtype','rtype_id',
            'group_full','group_work','group_view', 'workers', 'deadline'
        ]
    });
    var gridWork = Ext.create('Ext.grid.Panel', {
        store: storeWork,
        forceFit: true,
        columns: [
            {
                text: '№',
                sortable: true,
                dataIndex: 'id',
                resizable: false,
                width: 40
            },
            {
                text: 'Открыта',
                sortable: true,
                resizable: false,
                dataIndex: 'regtime',
                width: 100
            },
            {
                text: 'Подразделение',
                sortable: true,
                dataIndex: 'department',
                width: 200
            },
            {
                text: 'Пользователь',
                sortable: true,
                dataIndex: 'fio',
                width: 120
            },
            {
                text: 'Телефон',
                dataIndex: 'phone',
                width: 120
            },
            {
                text: 'Компьютер',
                dataIndex: 'pc',
                width: 120
            },
            {
                text: 'Тип заявки',
                sortable: true,
                dataIndex: 'rtype',
                width: 200
            },
            {
                text: 'Исполнители',
                dataIndex: 'workers',
                width: 200
            }
        ],
        scroll: false,
        viewConfig: {
            style: {overflow: 'auto', overflowX: 'hidden'},
            stripeRows: true,
            getRowClass: function(record) {
                if (record.data.deadline == 1) {
                    return 'x-row-deadline';
                } else {
                    return "";
                }
            } 
        }
    });
    gridWork.on('itemclick', function(y, r) {
        showRequestDetails(r.data.id)
    });
    return gridWork;
}



function getCompleteGrid() {
    console.log('creating COMPLETE grid');
    var storeComplete = Ext.create('Ext.data.JsonStore', {
        storeId: 'complete',
        proxy: {
            type: 'ajax',
            url: 'index.php?r=request/complete',
            reader: {
                type: 'json',
                root: 'items',
                totalProperty: 'totalCount'
            }
        },
        idIndex: 0,
        autoLoad: true,
        fields: [
            'id', 'regtime', 'department','position','phone','fio','pc','ip',
            'description','closed','utime','uuser','rtype','rtype_id',
            'group_full','group_work','group_view', 'workers', 'deadline'
        ]
    });
    var gridComplete = Ext.create('Ext.grid.Panel', {
        store: storeComplete,
        forceFit: true,
        columns: [
            {
                text: '№',
                sortable: true,
                dataIndex: 'id',
                resizable: false,
                width: 40
            },
            {
                text: 'Открыта',
                sortable: true,
                resizable: false,
                dataIndex: 'regtime',
                width: 100
            },
            {
                text: 'Подразделение',
                sortable: true,
                dataIndex: 'department',
                width: 200
            },
            {
                text: 'Пользователь',
                sortable: true,
                dataIndex: 'fio',
                width: 120
            },
            {
                text: 'Телефон',
                dataIndex: 'phone',
                width: 120
            },
            {
                text: 'Компьютер',
                dataIndex: 'pc',
                width: 120
            },
            {
                text: 'Тип заявки',
                sortable: true,
                dataIndex: 'rtype',
                width: 200
            },
            {
                text: 'Исполнители',
                dataIndex: 'workers',
                width: 200
            }
        ],
        scroll: false,
        viewConfig: {
            style: {overflow: 'auto', overflowX: 'hidden'},
            stripeRows: true,
            getRowClass: function(record) {
                if (record.data.deadline == 1) {
                    return 'x-row-deadline';
                } else {
                    return "";
                }
            } 
        }
    });
    gridComplete.on('itemclick', function(y, r) {
        showRequestDetails(r.data.id)
    });
    return gridComplete;
}

function getTree() {
    console.log('creating tree');
    var storeTree = new Ext.create("Ext.data.TreeStore", {
        storeId: 'tree',
        root: {
            expanded: true,
            id: -1,
            text: 'Все заявки'
        },
        proxy: {
            type: 'ajax',
            url: 'index.php?r=data/rtypes'
        },
        autoLoad: true
    });

    var tree = new Ext.tree.TreePanel({
        store: storeTree,
        rootVisible: true
    });
    tree.on('itemclick', function(node, record) {
        setRTFilter(record.data.id, record.data.text);
    });
    return tree;
}