function getFromDate(time) {
  const date = Date.parse(time);
  const today = new Date().getTime();

  const miliseconds = (today - date) / (1000 * 60);
  if (miliseconds < 1) {
    return " 1 minutes ago";
  } else if (miliseconds > 1 && miliseconds < 60) {
    return `${miliseconds} minutes ago`;
  } else if (miliseconds > 60 && miliseconds < 60 * 24) {
    let time = Math.floor(miliseconds / 60);
    return `${time} hours ago`;
  } else if (miliseconds > 60 * 24) {
    let time = Math.floor(miliseconds / (60 * 24));
    return `${time} date ago`;
  }
}
