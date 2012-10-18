<script>
Ext.application({
    name: 'Helpdesk',
    launch: function() {
	Ext.create('Ext.container.Viewport', {
	    layout: 'fit',
	    items: {
                title: 'Вход в систему',
                src: '?r=logon/form'
            }
	    
	})
    }
});
</script>