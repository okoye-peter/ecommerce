function dropDown(element) {
    element.parentNode.querySelectorAll('.accordion').forEach(li => {
        if (li.classList.contains('actives') && li != element) {
            li.classList.remove('actives');
            li.nextElementSibling.style.maxHeight = null;
        }
    });
    element.classList.toggle('actives');

    var panel = element.nextElementSibling;
    if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
    } else {
        panel.style.maxHeight = panel.scrollHeight + 'px';
    }

}

function sidebarTooggle() {
    let sidebar = document.getElementById("sidebar");
    sidebar.getElementsByClassName('closebtn')[0].style.display = 'inline-block';
    if (sidebar.style.width == "13em") {
        closeNav(sidebar.querySelector('.closebtn'));
        return;
    }
    sidebar.style.width = "13em";
    return false;
}

function closeNav(btn) {
    btn.parentNode.style.width = '0px';
    btn.style.display = 'none';
}

function endAlert(event, div = null) {
    let alt = document.querySelector('.add_to_cart_alert');
    event.target.parentNode.parentNode.classList.remove('active');
    setTimeout(() => {
        alt.removeChild(event.target.parentNode.parentNode);
    }, 250)
}

function createAlert(name) {
    let alert_div = document.createElement('div');
    alert_div.setAttribute('class', 'alerts');
    let span = document.createElement('span');
    let a = document.createElement('a');
    a.setAttribute('href', 'javascript:void(0)');
    let text = document.createTextNode(`${name} added to cart successfully `);
    span.appendChild(text);
    span.appendChild(a);
    let timer_div = document.createElement('div');
    timer_div.setAttribute('class', 'time');
    alert_div.appendChild(span);
    alert_div.appendChild(timer_div);
    let wrapper = document.querySelector('.add_to_cart_alert');
    wrapper.appendChild(alert_div);
    toggleAlert(alert_div, wrapper);
}

function toggleAlert(div, wrapper) {
    setTimeout(() => {
        div.classList.add('active');
    }, 500);
    wrapper.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', endAlert);
    });
    setTimeout(() => {
        countdown.apply({
            width: 100,
            count: 0,
        }, [div]);
    }, 900);
}

function countdown(div) {
    let b = setInterval(() => {
        let time = div.querySelector('.time');
        if (time.style.width === '0%' && this.count == 327) {
            div.classList.remove('active');
            this.width = 100;
            this.count = 0;
            setTimeout(() => {
                if (document.querySelector('.add_to_cart_alert').contains(div)) {
                    div.parentNode.removeChild(div);
                }
            }, 250)
            clearInterval(b);
        } else {
            this.width--;
            this.count++;
            time.style.width = this.width + "%";
        }
    }, 10);
}