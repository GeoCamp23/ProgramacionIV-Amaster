
//Vue.component('v-select', VueSelect.VueSelect);

var appVehiculos = new Vue({

    el:'#frmVehiculos',

    data:{

        Vehiculos:{

            idVehiculo : '',
            accion      : $("#frmVehiculos").data("accion"),
            marca     : '',
            modelo    : '',
            year   :   '',
            msg         : ''

        },

    },
    methods:{

        guardarVehiculos:function(){
            
            console.log(JSON.stringify(this.Vehiculos));
            fetch(`private/Modulos/Vehiculos/procesos.php?proceso=recibirDatos&Vehiculos=${JSON.stringify(this.Vehiculos)}`).then( resp=>resp.json() ).then(resp=>{
               
               console.log(resp)
                this.Vehiculos.msg = resp.msg;
                this.Vehiculos.marca = '';
                this.Vehiculos.modelo = '';
                this.Vehiculos.year  = '';
                this.Vehiculos.idVehiculo = 0;
                this.Vehiculos.accion = 'nuevo';
                
            });

        },
        buscarVehiculos:function(){

            appBuscarVehiculos.buscarVehiculos();

        }

    },
    created: function(){


    }
    
});

var appBuscarVehiculos = new Vue({

    el:'#frm-buscar-Vehiculos',

    data:{
        Vehiculoses:[],
        valor:''
    },
    methods:{

        buscarVehiculos:function(){
            fetch(`private/Modulos/Vehiculos/procesos.php?proceso=buscarVehiculos&Vehiculos=${this.valor}`).then(resp=>resp.json()).then(resp=>{
                this.Vehiculoses = resp;
            });
        },
        modificarVehiculos:function(Vehiculos){
            console.log(Vehiculos.idVehiculo)
            appVehiculos.Vehiculos = Vehiculos;
            appVehiculos.Vehiculos.accion = 'modificar';
            
        },
        verificacionEliminacion:function(idVehiculo){
            alertify.confirm('Alerta', 'Esta seguro de eliminar este registro',function(){
                appBuscarVehiculos.eliminarVehiculos(idVehiculo);
                alertify.success('Registro Eliminado');
                
            }, function() {
                alertify.error('Cancelado');
                
            });
            
        },
        eliminarVehiculos(id){
            console.log(id);
            
            fetch(`private/Modulos/Vehiculos/procesos.php?proceso=eliminarVehiculos&Vehiculos=${id}`).then(resp=>resp.json()).then(resp=>{
               console.log(resp)
                this.buscarVehiculos();
            });
        }
    },
    created:function(){
        this.buscarVehiculos();
    }

    
});