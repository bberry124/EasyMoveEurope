addEventListener('scroll', (event) => {
    let element = document.getElementById('service_footer').clientHeight;
    let service_footer_scrollTop = document.querySelector('#service_footer').offsetTop;
    let current_scrollY = window.scrollY;
    if(service_footer_scrollTop-element-190 > current_scrollY) {
        document.querySelector('#fix_footer').style.display = 'block';    
    } else {
        document.querySelector('#fix_footer').style.display = 'none';    
    }
});