const { app, BrowserWindow, Menu, ipcMain, Notification } = require('electron');
const path = require('path');
const fs = require('fs');

// Global variables for windows
let mainWindow;

// Function to create the main window
function createMainWindow() {
  // Create the browser window
  mainWindow = new BrowserWindow({
    width: 800,
    height: 600,
    webPreferences: {
      nodeIntegration: true
    },
    icon: path.join(__dirname, 'app-icon.png')
  });

  // Load the index.html file
  mainWindow.loadFile(path.join(__dirname, 'index.html'));

  // Create the application menu
  const template = [
    {
      label: 'Select AI',
      submenu: [
        { label: 'Chat GPT 3', click: () => loadURL('https://chat.openai.com/auth/login') },
        { label: 'DALLE', click: () => loadURL('https://labs.openai.com/') },
        { label: 'POE', click: () => loadURL('https://poe.com/') },
        { label: 'Microsoft Designer', click: () => loadURL('https://designer.microsoft.com/') },
        { label: 'Firefly', click: () => loadURL('https://firefly.adobe.com/') },
        { label: 'Remove Background', click: () => loadURL('https://www.remove.bg/') },
        { label: 'Kick Resume', click: () => loadURL('https://www.kickresume.com/en/') },
        { label: 'Tome', click: () => loadURL('https://auth.tome.app/u/signup') },
        { label: 'Tutorial', click: () => loadURL('https://www.tutorai.me/') },
        { label: 'Quizify', click: () => loadURL('https://quizify.com/') },
        { label: 'Bard', click: () => loadURL('https://bard.google.com/') }
      ]
    },
    {
      label: 'Services',
      submenu: [
        // Add submenu items for services
      ]
    },
    {
      label: 'Settings',
      submenu: [
        {
          label: 'Set Window Size',
          click: () => {
            createSettingsWindow();
          }
        },
        {
          label: 'Configure Services',
          click: () => {
            // Open the settings page in the main window
            mainWindow.loadFile(path.join(__dirname, 'settings.html'));
          }
        }
      ]
    }
  ];

  const menu = Menu.buildFromTemplate(template);
  Menu.setApplicationMenu(menu);
}

function createSettingsWindow() {
    // Create the settings window
    const settingsWindow = new BrowserWindow({
      width: 400,
      height: 300,
      parent: mainWindow,
      modal: true,
      webPreferences: {
        nodeIntegration: true
      }
    });
  
    // Load the settings.html file
    settingsWindow.loadFile(path.join(__dirname, 'settings.html'));
  
    // Handle the 'close' event of the settings window
    settingsWindow.on('close', () => {
      // Send an IPC message to the main window to update the checkbox status
      mainWindow.webContents.send('update-fullscreen-checkbox');
    });
  }

// IPC event listener to handle getting window size settings
ipcMain.on('get-window-size-settings', (event) => {
    const settingsFilePath = path.join(app.getPath('userData'), 'windowSettings.json');
    if (fs.existsSync(settingsFilePath)) {
      const settings = JSON.parse(fs.readFileSync(settingsFilePath));
      event.reply('send-window-size-settings', settings);
    }
  });

// Function to save the window size settings to a file
function saveWindowSizeSettings(width, height, useFullScreen) {
  const settings = {
    width,
    height,
    useFullScreen
  };

  // Save the settings to a file
  const settingsFilePath = path.join(app.getPath('userData'), 'windowSettings.json');
  fs.writeFileSync(settingsFilePath, JSON.stringify(settings));

  // Show a notification to indicate that settings were saved
  new Notification({
    title: 'Settings Saved',
    body: 'Window size settings have been saved.'
  }).show();
}

// Function to load a URL in the main window
function loadURL(url) {
  mainWindow.loadURL(url);
}

// Event listener for the 'app ready' event
app.on('ready', createMainWindow);

// Event listener for the 'window-all-closed' event
app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

// Event listener for the 'activate' event
app.on('activate', () => {
  if (BrowserWindow.getAllWindows().length === 0) {
    createMainWindow();
  }
});

// IPC event listener to handle saving window size settings
ipcMain.on('save-window-size-settings', (event, arg) => {
  const { width, height, useFullScreen } = arg;
  saveWindowSizeSettings(width, height, useFullScreen);
});
