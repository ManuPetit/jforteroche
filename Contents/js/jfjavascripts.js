/* 
 * Javascript file
 */

/**
 * Method to create a form on the fly to 
 * 
 * @param {int} idComment   The ID of the comment
 * @param {int} idChapter   The ID of the chapter
 * @returns {html}
 */
function answerComment(idComment, idChapter) {
    var frm = document.getElementById("frm" + idComment);
    var createform = document.createElement('form'); // Create New Element Form
    createform.setAttribute("action", "chapitre/repondre"); // Setting Action Attribute on Form
    createform.setAttribute("method", "post"); // Setting Method Attribute on Form
    createform.setAttribute("class", "message");
    createform.setAttribute("onsubmit", "return validateForm();")
    frm.appendChild(createform);

    var heading = document.createElement('h4'); //heading of comment box
    heading.innerHTML = "Repondez à ce message :";
    createform.appendChild(heading);

    var paragraph = document.createElement('p');
    createform.appendChild(paragraph);

    var label1element = document.createElement('label'); //label for name input
    label1element.setAttribute("for", "pseudo");
    label1element.innerHTML = "Nom :";
    paragraph.appendChild(label1element);

    var linebreak = document.createElement('br');
    paragraph.appendChild(linebreak);

    var inputelement = document.createElement('input'); // Create Input Field for Name
    inputelement.setAttribute("type", "text");
    inputelement.setAttribute("id", "pseudo");
    inputelement.setAttribute("name", "pseudo");
    inputelement.setAttribute("placeholder", "Tapez votre nom...");
    inputelement.setAttribute("required", "");
    paragraph.appendChild(inputelement);

    var err1linebreak = document.createElement('br');
    paragraph.appendChild(err1linebreak);

    var perror1 = document.createElement('span'); // Create error element for pseudo
    perror1.setAttribute("id", "error1");
    perror1.setAttribute("class", "error");
    paragraph.appendChild(perror1);

    var paragraph2 = document.createElement('p');
    createform.appendChild(paragraph2);

    var label2element = document.createElement('label'); //label for textearea
    label2element.setAttribute("for", "response");
    label2element.innerHTML = "Votre message :";
    paragraph2.appendChild(label2element);

    var linebreak2 = document.createElement('br');
    paragraph2.appendChild(linebreak2);

    var texareaelement = document.createElement('textarea');
    texareaelement.setAttribute("id", "response");
    texareaelement.setAttribute("name", "response");
    texareaelement.setAttribute("placeholder", "Tapez votre message...");
    texareaelement.setAttribute("rows", "6");
    paragraph2.appendChild(texareaelement);

    var err2linebreak = document.createElement('br');
    paragraph2.appendChild(err2linebreak);

    var perror2 = document.createElement('span'); // Create error element for comment
    perror2.setAttribute("id", "error2");
    perror2.setAttribute("class", "error");
    paragraph2.appendChild(perror2)

    var chapterelement = document.createElement('input'); // Create Input Field for chapter id    
    chapterelement.setAttribute("name", "idchap");
    chapterelement.setAttribute("type", "hidden");
    chapterelement.setAttribute("value", idChapter);
    createform.appendChild(chapterelement);

    var commentelement = document.createElement('input'); //create input field for comment id
    commentelement.setAttribute("name", "idcom");
    commentelement.setAttribute("type", "hidden");
    commentelement.setAttribute("value", idComment);
    createform.appendChild(commentelement);

    var submitelement = document.createElement('button'); // Append Submit Button
    submitelement.setAttribute("type", "submit");
    submitelement.setAttribute("name", "submit");
    submitelement.setAttribute("class", "button-submit");
    submitelement.innerHTML = "Répondre";
    createform.appendChild(submitelement);

    //hide the icon
    var icon = "icon-response" + idComment;
    link = document.getElementById(icon);
    link.style.display = "none";
}

function validateForm() {
    var pseudo = document.getElementById("pseudo").value;
    var response = document.getElementById("response").value;
    var flagp = true;
    var flagr = true;
    if (pseudo != '') {
        var patt = new RegExp('^[a-zA-Z0-9_ éèêêçàùîïô]{3,80}$');
        flagp = patt.test(pseudo);
        if (flagp == false) {
            document.getElementById("error1").innerHTML = "Attention : lettres ou chiffres uniquement, de 3 à 80 caractères";
        }
    } else {
        flagp = false;
        document.getElementById("error1").innerHTML = "Attention : vous devez entrer une valeur dans ce champs";
    }
    if (response == '') {
        flagr = false;
        document.getElementById("error2").innerHTML = "Attention : vous devez entrer une valeur dans ce champs";
    }
    if (!flagp || !flagr) {
        return false;
    } else {
        return true;
    }
}

