const { ipcRenderer } = require('electron');

document.addEventListener('DOMContentLoaded', () => {
  const widthInput = document.getElementById('widthInput');
  const heightInput = document.getElementById('heightInput');
  const saveButton = document.getElementById('saveButton');
  const fullscreenCheckbox = document.getElementById('fullscreenCheckbox');

  // Load saved window size on page load
  loadWindowSize();

  // Add event listener to save button
  saveButton.addEventListener('click', () => {
    const width = widthInput.value;
    const height = heightInput.value;
    const useFullscreen = fullscreenCheckbox.checked;

    // Save window size and fullscreen preference
    saveWindowSize(width, height, useFullscreen);

    // Show notification
    alert('Window size and fullscreen preference have been saved.');

    // Send message to main process to restart the app
    ipcRenderer.send('app-restart');
  });

  // Function to load saved window size and fullscreen preference
  function loadWindowSize() {
    const savedSize = getSavedWindowSize();
    if (savedSize) {
      widthInput.value = savedSize.width;
      heightInput.value = savedSize.height;
      fullscreenCheckbox.checked = savedSize.fullscreen;
    }
  }

  // Function to save window size and fullscreen preference
  function saveWindowSize(width, height, useFullscreen) {
    const windowSize = {
      width: parseInt(width),
      height: parseInt(height),
      fullscreen: useFullscreen
    };
    localStorage.setItem('windowSize', JSON.stringify(windowSize));
  }

  // Function to retrieve saved window size and fullscreen preference
  function getSavedWindowSize() {
    const savedSize = localStorage.getItem('windowSize');
    return savedSize ? JSON.parse(savedSize) : null;
  }
});
