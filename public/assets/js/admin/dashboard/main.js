document.addEventListener('DOMContentLoaded', function () {

    function logoResizer(){
        if(window.innerWidth < 576){
            document.getElementById('telkomLogo').style.width = "20%";
            document.getElementById('telkomLogo').style.height = "20%";
        }else{

            document.getElementById('telkomLogo').style.width = "5%";
            document.getElementById('telkomLogo').style.height = "5%";
        }
    }
    logoResizer();
    window.addEventListener('resize', logoResizer);

    function itVisual(){
        if(window.innerWidth < 576){
            document.getElementById('itVisual').style.width = "100%";
            document.getElementById('itVisual').classList.add('mt-5');
            // document.getElementById('itVisual').style.height = "20%";
        }else{
            document.getElementById('itVisual').style.width = "";
            document.getElementById('itVisual').classList.remove('mt-5');
        }
    }

    itVisual();
    window.addEventListener('resize', itVisual);

});

$('#penggunaBtn').on('click', function () {

    document.getElementById('penggunaBtn').classList.remove('bg-light');
    document.getElementById('penggunaBtn').classList.add('bg-primary');

});

$('#dataBtn').on('click', function () {

    document.getElementById('dataBtn').classList.remove('bg-light');
    document.getElementById('dataBtn').classList.add('bg-primary');

});

$('#beriTugasBtn').on('click', function () {

    document.getElementById('beriTugasBtn').classList.remove('bg-light');
    document.getElementById('beriTugasBtn').classList.add('bg-primary');

});

$('#tugasBtn').on('click', function () {

    document.getElementById('tugasBtn').classList.remove('bg-light');
    document.getElementById('tugasBtn').classList.add('bg-primary');

});
