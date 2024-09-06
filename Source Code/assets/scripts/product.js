const hover_element = document.getElementById('effect');

//Listen for mouse move
hover_element.addEventListener('mousemove', handleHover);
//Function for mouse movement
function handleHover(event) {
  //Calculate rotations based on mouse position
  const x_rotation = -40 * ((event.layerY - hover_element.clientHeight / 2) / hover_element.clientHeight);
  const y_rotation = 40 * ((event.layerX - hover_element.clientWidth / 2) / hover_element.clientWidth);
  //Combine transforms into string
  const transform_string = `perspective(300px) scale(1.2) rotateX(${x_rotation}deg) rotateY(${y_rotation}deg)`;
  //Apply transforms to element
  hover_element.style.transform = transform_string;
}

//Reset transform on mouse out
hover_element.addEventListener('mouseout', () => {
  hover_element.style.transform = 'perspective(300px) scale(1) rotateX(0) rotateY(0)';
});