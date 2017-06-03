# UniSave
A complete save and loading parser for Unity3D (Not Json or XML). Completely custom from the ground up.
READ ME

Simple instructions.

Upon importing you will get a RegEX Error, to fix this go to Edit > Project Settings > Player.
Then click on Other Options and change Api Compatibility Level to .Net 2.0 (NOT SUBSET).

Now - Drag and drog SaveParser onto an empty gameobject.
Drag and Drop LoadGame onto the same object (if you want).

Now inside SaveParser go to Prefabs drop down and add every Prefab that you will be wanting to save and load.

That's pretty much it.
Keep in mind (this Initial) version will only work properly for PREFABS. It will work for Local (Non-Instantiated) objects, but it will still load the object again.


Initial Controls -
Spacebar - Saves.
L - loads the file.

Be sure to go into SaveParser and LoadGame scripts and change the Save/Load File to your desire (Saves to Application.dataPath).
