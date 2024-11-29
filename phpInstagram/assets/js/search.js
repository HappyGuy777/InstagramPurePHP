function search(e) {
    const search=document.getElementById("search")
    let searchval=search.value;

    const searchtext=document.getElementById("searchtext")
    let searchtextValue=searchtext.value;
    console.log(searchval)
    const url = "../../action/searchAction.php"
    const data = new URLSearchParams()

    data.append('word', searchtextValue)
    data.append('search',searchval)
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
            result = JSON.parse(result)
            const body = document.querySelector(".result")

            body.innerHTML = ""
            if (result=="empty"){
                const container = document.createElement("h2")
                body.append(container)
                container.innerText="Search something..."
            }else {
                if (result==""){
                    const container = document.createElement("h2")
                    body.append(container)
                    container.innerText="No such result."
                }else {
                    result.map((el)=>{

                        const container = document.createElement("div")
                        const container1 = document.createElement("div")
                        container.appendChild(container1)
                        container.classList.add('like_info')
                        const avatar = document.createElement("img")
                        const link = document.createElement("a")
                        const button=document.createElement("button")
                        button.innerText='follow'
                        console.log(result)
                        avatar.src = el[5]
                        avatar.classList.add('avatar')
                        body.append(container)
                        container1.append(avatar)
                        console.log(el[10])
                        if (el[10]){
                            link.innerText=el[10]
                        }else{
                            link.innerText=el[2]
                        }
                        link.href="./userProfile.php?user_id="+el[0]
                        container1.appendChild(link)
                        container.appendChild(button)

                    })
                }
                }


        })
        .catch(error => {
            console.log(error)
        })

}