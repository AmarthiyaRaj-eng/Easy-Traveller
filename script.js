function flyToPage(page){

    document.getElementById("plane").classList.add("fly");

    document.querySelectorAll(".smoke").forEach(smoke=>{
        smoke.classList.add("smokeFly");
    });

    setTimeout(()=>{

        window.location.href=page;

    },1200);

}