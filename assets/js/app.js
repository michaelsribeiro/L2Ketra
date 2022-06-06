let accBtn = document.querySelectorAll('.menu-nav a');

accBtn.forEach((item) => {
    if(item.classList.contains('active')){        
        item.setAttribute('href', 'javascript:void(0)');
    }

    item.addEventListener("click", (event) => {
        let element = event.target;
        
        if(!element.classList.contains('active')) {
            element.classList.add('active');
        } else {
            element.classList.remove('active')
            element.classList.add('active');
        }
    });
})  