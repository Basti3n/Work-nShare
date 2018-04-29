var click;

var Idclick;

function clicked(value,id){
	click = value;
	Idclick = id;
	console.log(value);
	remove();
	switch (click){
		case "Surface Laptop" : 
			document.getElementById("model").style.visibility = 'visible';
			drawSurfLap();
			break;
		case "Surface Pro" :
			document.getElementById("model").style.visibility = 'visible';
			drawSurfPro();
			break;
		case "Surface Pro 2":
			document.getElementById("model").style.visibility = 'hidden';
			break;
	}
	if(click.includes('Salle R')){
		document.getElementById("model").style.visibility = 'visible';
		drawReunion();
	}
}

function remove(){
	var selectedObject = scene.getObjectByName("pc0");
    scene.remove( selectedObject );
    selectedObject = scene.getObjectByName("pc1");
    scene.remove( selectedObject );
}


var camera, scene, renderer,controls;
var mesh;
var light,light2,light3;
init();
animate();

function init() {
	camera = new THREE.PerspectiveCamera( 70, window.innerWidth / window.innerHeight, 1, 100 );
	camera.position.z = 10;
	camera.position.x = 5;
	camera.rotation.x =2*Math.PI/3;
	camera.position. y = 2;
	scene = new THREE.Scene();

	renderer = new THREE.WebGLRenderer();
	renderer.setPixelRatio( window.devicePixelRatio );
	renderer.domElement.id="canvas";
	renderer.setSize( window.innerWidth, window.innerHeight );
	document.getElementById("model").appendChild( renderer.domElement );
	var AxesHelper = new THREE.AxesHelper(200);
	scene.add(AxesHelper);

	controls = new THREE.OrbitControls( camera,document.getElementById("model"));
	controls.enableZoom = true;
	controls.maxDistance = 90;
	
	var light = new THREE.AmbientLight( 0x404040 ); // soft white light
	scene.add( light );
	var light2 = new THREE.HemisphereLight(0xffffff, 0x444444, 1.0);
	light2.position.set(0, 1, 0);
	scene.add(light2);

	var light3 = new THREE.DirectionalLight(0xffffff, 1.0);
	light3.position.set(0, 1, 0);
	scene.add(light3);

	//clicked(0);

    window.addEventListener( 'resize', onWindowResize, false );
    controls.update();

}

function onWindowResize() {
	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();
	renderer.setSize( window.innerWidth, window.innerHeight );
}
function animate() {
	requestAnimationFrame( animate );
	renderer.render( scene, camera );
}

function drawSurfLap(){
	THREE.Loader.Handlers.add( /.dds$/i, new THREE.DDSLoader() );
    var mtlLoader = new THREE.MTLLoader();
    mtlLoader.setPath( 'modele/Surface Laptop/' );
    mtlLoader.load( 'test.mtl', function( materials ) {
        materials.preload();
        var objLoader = new THREE.OBJLoader();
        objLoader.setMaterials( materials );
        objLoader.setPath( 'modele/Surface Laptop/' );
        objLoader.load( 'test.obj', function ( object ) {
            object.scale.set(10,10,10);
            //object.position.y = -10;
            object.name= "pc0";
            object.rotation.x=3*Math.PI/2;
            scene.add( object );
        } );
    });
}

function drawSurfPro(){
	THREE.Loader.Handlers.add( /.dds$/i, new THREE.DDSLoader() );
    var mtlLoader = new THREE.MTLLoader();
    mtlLoader.setPath( 'modele/Surface Pro/' );
    mtlLoader.load( 'surface pro.mtl', function( materials ) {
        materials.preload();
        var objLoader = new THREE.OBJLoader();
        objLoader.setMaterials( materials );
        objLoader.setPath( 'modele/Surface Pro/' );
        objLoader.load( 'surface pro.obj', function ( object ) {
            object.scale.set(10,10,10);
            //object.position.y = -10;
            object.name= "pc1";
            object.rotation.x=3*Math.PI/2;
            scene.add( object );
        } );
    });
}

function drawReunion(){
	THREE.Loader.Handlers.add( /.dds$/i, new THREE.DDSLoader() );
    var mtlLoader = new THREE.MTLLoader();
    mtlLoader.setPath( 'modele/Reunion/' );
    mtlLoader.load( 'interieur.mtl', function( materials ) {
        materials.preload();
        var objLoader = new THREE.OBJLoader();
        objLoader.setMaterials( materials );
        objLoader.setPath( 'modele/Reunion/' );
        objLoader.load( 'interieur.obj', function ( object ) {
            object.scale.set(10,10,10);
            //object.position.y = -10;
            object.name= "test";
            object.rotation.x=3*Math.PI/2;
            scene.add( object );
        });
    });
    console.log('loaded');
}