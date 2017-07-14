/* 
 * Javascript file
 */

function answerComment(idComment, idChapter) {
    var frm = document.getElementById("frm" + idComment);
    var createform = document.createElement('form'); // Create New Element Form
    createform.setAttribute("action", "chapitre/repondre"); // Setting Action Attribute on Form
    createform.setAttribute("method", "post"); // Setting Method Attribute on Form
    createform.setAttribute("class", "message");
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

    var chapterelement = document.createElement('input'); // Create Input Field for chapter id    
    chapterelement.setAttribute("name", "idchapter");
    chapterelement.setAttribute("type", "hidden");
    chapterelement.setAttribute("value", idChapter);
    createform.appendChild(chapterelement);
    
    var commentelement = document.createElement('input'); //create input field for comment id
    commentelement.setAttribute("name", "idcomment");
    commentelement.setAttribute("type", "hidden");
    commentelement.setAttribute("value", idComment);
    createform.appendChild(commentelement);

    var submitelement = document.createElement('button'); // Append Submit Button
    submitelement.setAttribute("type", "submit");
    submitelement.setAttribute("name", "submit");
    submitelement.setAttribute("class","button-submit");
    submitelement.innerHTML = "Répondre";
    createform.appendChild(submitelement);

    //hide the icon
    var icon = "icon-response" + idComment;
    link = document.getElementById(icon);
    link.style.display = "none";    
}


