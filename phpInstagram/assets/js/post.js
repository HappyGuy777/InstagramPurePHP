// Function to change the color of the SVG icon to red
// Function to toggle the color of the SVG icon
function like( post_id, user_id) {
    let heart = document.getElementById(`heart${post_id}`)
    let span=document.getElementById(`like_count${post_id}`)
    const url = "../../action/likeAction.php"
    const data = new URLSearchParams()
    let likes=+span.innerText
    data.append('post_id', post_id)
    data.append('user_id', user_id)
    if (heart.getAttribute('fill')=='white') {
        heart.setAttribute('fill', 'red')
        data.append("status", "insert")
        likes+=1
        span.innerText=likes;
    }
    else {
        heart.setAttribute('fill', 'white')
        data.append("status", "delete")
        likes-=1
        span.innerText=likes;
    }
    fetch(url, {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": 'application/x-www-form-urlencoded'
        }
    })
        .then(response => response.text())
        .then(result => {
            console.log(result)
        })
        .catch(error => {
            console.log(error)
        })


}
function save( post_id, user_id,hasSave) {
    let save = document.getElementById(`save${post_id}`)
    let span=document.getElementById(`save_count${post_id}`)
    let path=document.getElementById("path"+post_id)
    const savedPath = 'M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z';
    const unsavedPath = 'M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z';

    const url = "../../action/likeAction.php"
    const data = new URLSearchParams()
    let likes=+span.innerText
    data.append('post_id', post_id)
    data.append('user_id', user_id)
    console.log(hasSave)

    console.log(path.getAttribute('d'))
    if (path.getAttribute('d')==savedPath) {
        console.log("a")
        path.setAttribute("d",unsavedPath)
        save.appendChild(path)
        data.append("status", "insert_save")
        likes+=1
        span.innerText=likes;
    }
    else {
        console.log("bb")
        path.setAttribute("d",unsavedPath)
        save.appendChild(path)
        data.append("status", "delete_save")
        likes-=1
        span.innerText=likes;
    }
    fetch(url, {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": 'application/x-www-form-urlencoded'
        }
    })
        .then(response => response.text())
        .then(result => {
            console.log(result)
        })
        .catch(error => {
            console.log(error)
        })


}
function openModal( post_id,ind,typ) {
    //modal creating
    let main=document.getElementsByTagName('main')[0]
    let modalPass=document.createElement('div')
    modalPass.id = `modalPass${post_id}`;
    modalPass.className = 'modal';

    const modalContentDiv = document.createElement('div');
    modalContentDiv.className = 'modal-content scroll';

    const modalLikesDiv = document.createElement('div');
    modalLikesDiv.className = 'modal-likes';

    const underDiv = document.createElement('div');
    underDiv.className = 'under';
    const h2 = document.createElement('h2');
    if (typ){
        h2.textContent="All saves"
    }else {

        h2.textContent = 'All Likes';
    }
    underDiv.appendChild(h2);

    let closeButton = document.createElement('span');
    closeButton.id = `close${post_id}`;
    closeButton.className = 'close';
    closeButton.textContent = '×';

    const likeContDiv = document.createElement('div');
    likeContDiv.className = 'like_cont';
    modalLikesDiv.appendChild(underDiv);
    modalLikesDiv.appendChild(closeButton);
    modalLikesDiv.appendChild(likeContDiv);
    modalContentDiv.appendChild(modalLikesDiv);
    modalPass.appendChild(modalContentDiv);

    main.appendChild(modalPass);

    //modal show/close
    modalPass.style.display = "flex";
    const body=document.getElementsByTagName("body")[0]
    body.style.overflow="hidden"
        // Close the modal if the user clicks the close button
        closeButton.addEventListener("click", () => {
            main.removeChild(modalPass)
            body.style.overflow="visible"
        });

        // Close the modal if the user clicks outside of it
        window.addEventListener("click", (event) => {
            if (event.target === modalPass) {
                main.removeChild(modalPass)
                body.style.overflow="visible"
            }
        });


        //request
    const url = "../../action/showLikesAction.php"
    const data = new URLSearchParams()
    data.append('post_id', post_id)
    data.append('func', 'show_saves')
    fetch(url,{
        method: "POST",
        body: data,
        headers: {
            "Content-Type": 'application/x-www-form-urlencoded'
        }
    })
   .then(response => response.text())
        .then(result => {
            result = JSON.parse(result);
            console.log(result)
            result.forEach(function (item) {
                const avatarUrl = item[0];
                const username = item[1];
                const id=item[2];
                const likeLink = document.createElement('a');
                if (ind=='index'){
                    likeLink.href = "./pages/userProfile.php?user_id="+id;
                }else {
                    likeLink.href = "./userProfile.php?user_id="+id;
                }


                const likeInfoDiv = document.createElement('div');
                likeInfoDiv.className = 'like_info';

                const avatarImg = document.createElement('img');
                avatarImg.src = avatarUrl;
                avatarImg.className = 'avatar';

                const usernameSpan = document.createElement('span');
                usernameSpan.textContent = username;

                likeInfoDiv.appendChild(avatarImg);
                likeInfoDiv.appendChild(usernameSpan);

                likeLink.appendChild(likeInfoDiv);
                likeContDiv.appendChild(likeLink);
            });
        })

        .catch(error => {
            console.log(error)
        })
}
function request(my_id,user_id,follow_req){
    const url = "../../action/requestAction.php";
    const sender_id=my_id;
    const receiver_id=user_id;
    const button=document.getElementById('follow-button')
    const data = new URLSearchParams();
    let follow=follow_req;
    console.log(follow)
        data.append('sender_id', sender_id);
        data.append('receiver_id',receiver_id);
        if (follow==undefined){
            follow="send"
        }else {
             follow="delete"
         }
    console.log(follow)
        data.append('follow',follow)
        fetch(url, {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": 'application/x-www-form-urlencoded'
        }
    })
        .then(response => response.text())
        .then(result => {
            console.log(result)
            window.location.reload()

        })
        .catch(error => {
            console.log(error);
        });

}
function accept(sender_id,my_id,follow){
    const url = "../../action/requestAction.php";
    const send_id=sender_id;
    const rec_id=my_id
    const notify=document.getElementById("notify_user"+send_id)
    console.log(notify)
    let follow_req=follow;
    const data = new URLSearchParams();
    data.append('sender_id', send_id);
    data.append('receiver_id',rec_id);
    data.append('follow',follow_req)
    fetch(url, {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": 'application/x-www-form-urlencoded'
        }
    })
        .then(response => response.text())
        .then(result => {
            console.log(result)
            notify.remove()
            window.location.reload()

        })
        .catch(error => {
            console.log(error);
        });
}

function following(user_id,func_type){
    let main=document.getElementsByTagName('main')[0]
    let modalPass=document.createElement('div')
    const users_id=user_id;
    const funcs_type=func_type;
    let likeText='';
    if (funcs_type=='following'){
        likeText="My followings";
    }else if (funcs_type=='followers'){
        likeText="My followers";
    }
    modalPass.id = `modalPass${user_id}`;
    modalPass.className = 'modal';

    const modalContentDiv = document.createElement('div');
    modalContentDiv.className = 'modal-content scroll';

    const modalLikesDiv = document.createElement('div');
    modalLikesDiv.className = 'modal-likes';

    const underDiv = document.createElement('div');
    underDiv.className = 'under';
    const h2 = document.createElement('h2');
    h2.textContent =likeText;
    underDiv.appendChild(h2);

    let closeButton = document.createElement('span');
    closeButton.id = `close${user_id}`;
    closeButton.className = 'close';
    closeButton.textContent = '×';

    const likeContDiv = document.createElement('div');
    likeContDiv.className = 'like_cont';
    modalLikesDiv.appendChild(underDiv);
    modalLikesDiv.appendChild(closeButton);
    modalLikesDiv.appendChild(likeContDiv);
    modalContentDiv.appendChild(modalLikesDiv);
    modalPass.appendChild(modalContentDiv);

    main.appendChild(modalPass);

    //modal show/close
    modalPass.style.display = "flex";
    const body=document.getElementsByTagName("body")[0]
    body.style.overflow="hidden"
    // Close the modal if the user clicks the close button
    closeButton.addEventListener("click", () => {
        main.removeChild(modalPass)
        body.style.overflow="visible"
    });

    // Close the modal if the user clicks outside of it
    window.addEventListener("click", (event) => {
        if (event.target === modalPass) {
            main.removeChild(modalPass)
            body.style.overflow="visible"
        }
    });
    const url = "../../action/showFollowingsAction.php";

    const data = new URLSearchParams();
    data.append('users_id', users_id);
    data.append('funcs_type', funcs_type);
    fetch(url, {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": 'application/x-www-form-urlencoded'
        }
    })
        .then(response => response.text())
        .then(result => {

            result = JSON.parse(result);
            console.log(result)
            result.forEach(function (item) {


                const avatarUrl = item[1];
                const username = item[0];
                const id= item[2];
                const likeLink = document.createElement('a');
                likeLink.href = "./userProfile.php?user_id="+id;

                const likeInfoDiv = document.createElement('div');
                likeInfoDiv.className = 'like_info';

                const avatarImg = document.createElement('img');
                avatarImg.src = avatarUrl;
                avatarImg.className = 'avatar';

                const usernameSpan = document.createElement('span');
                usernameSpan.textContent = username;

                likeInfoDiv.appendChild(avatarImg);
                likeInfoDiv.appendChild(usernameSpan);

                likeLink.appendChild(likeInfoDiv);
                likeContDiv.appendChild(likeLink);
            });

        })
        .catch(error => {
            console.log(error);
        });
}