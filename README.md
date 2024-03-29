# lizellba

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).


### Project architecture walkthrough.

Ce projet 

* The php scripts, mostly equivalent to the CRUD api endpoints (I only created the necessary endpoints), are situated under `src\assets\back`

* These phps scripts are called by the javascript api, found under `src\services\api\api.js`. See the doc embedded in file for methods descriptions.
* `src\Index\Index.vue` is the index page. It is basically a container for two other components: 
    * `src\Index\Components\Presentation.vue` contains the description of the game and the button to start the game, which then links to `\game` (ie `src\game\Game.vue`, see below)
    * `src\Index\Components\Gallery.vue` which consists of the gallery of expo photos (numeric and physical ones). Gallery component uses two others components:
        * Pagination.vue which is just a simple component to display the pages number on which to click.
        * PhotoModal.vue which is the modal which display the photo with info and share options when an expo is clicked on.
    

* `src\game\Game.vue` contains all which is the actual game. It first loads all questions and all artworks (just the raw DB data, it does not load the actual jpg imgs from server at this point). It listens to all the event from its child components (modals, question panel and exposition component) to handle the list of questions (adding, removing, randomly drawing next question) and list of artworks (adding artwork to expo, removing). . 
List of components used by `Game.vue`:
    * `src\game\components\Expostion.vue` is the main component.
    * `src\game\components\Question.vue` is the panel displaying the question. It is equivalent to a modal in logic but has a specific format so it does not inheric from `Modal.vue`. It emits the event **validateQuestionEvent** when the user validates its answer. **validateQuestionEvent** carries the parameters *correct* (boolean indicating if the answer is correct) and *expoId* (id of the corresponding expo to draw a corresponding artwork).
    * `AnswerModal`, `ClosingModal`, `DeleteArtworkModal`, `InfoArtworkModal`, `TutoModal`, `ValidateModal` are all modals, using the modal logic of `src\services\Modal.vue`
        * `src\game\components\AnswerModal.vue` is displayed when the user enter an answer. It displays if the answer is correct and the details of the answer. It emits the event **newQuestionEvent** to indicate that a new question must be drawed.
        * `src\game\components\DeleteArtworkModal.vue` is a modal that asks for confirmation when removing an artwork. It emits the event **confirmDeleteArtworkEvent** when the user confirm the deletion.
        * `src\game\components\InfoArtworkModal.vue` display the info of the artwork selected. It emits no specific event.
        * `src\game\components\ClosingModal.vue` is a modal that asks for confirmation when the user wants to quit the game without validating the expo. It emits the event **closeExpoEvent** if the user confirms he wants to quit. It emits the event **askExpoValidationEvent** if the user clicks on the "validate expo" option.
        * `src\game\components\TutoModal.vue` displays the game tutorial and is opened by default at the start of the game. It emits no specific event.
        * `src\game\components\ValidateModal.vue` asks for curator and expo name and then for confirmation of the validation. It emits the event **validateExpoEvent** (with curatorname and exponame as parameters) if all details have been filed and the user validated.


### Exposition component

See doc of KonvaJs lib here *https://konvajs.org/docs/vue/index.html*.  
The canva use this kinf of architecture: a stage node which is a container for different layers node. Each layer can contains differents objects (either images or vector like lines, rectangles).
Each node can be the target of different method, triggered by different actions (click, double-click, drag, etc).  
Here, the architecture is as is:

* stage "stage", the single stage container.
    * layer "background" which contains the background (the drawing of the expo space)
        * v-line "backgroundPoly" which draws the basic background
        * one v-line for each wall to contain the wall color. 
    * layer "wall" which contains all the artworks that goes on the wall
        * one v-image node for each floor artwork present in expo
    * layer "floor"  which contains all the artworks that goes on the floor
        * one v-image node for each wall artwork present in expo
    * layer "tools" which contains the tools icons when editing an artwork
        * v-image "watermark" which contains the logo "lizellba", hidden by default but to be displayed on the stored image
        * v-rect "toolsFrame" which is the rectangle around the artwork
        * v-group "icons"
            * v-image "InfoIcon" icon to display artwork details
            * v-image "DeleteIcon" icon to delete the artwork
            * v-image "EnlargeIcon" icon to augment artwork size
            * v-image "DeleteIcon" icon to reduce artwork size



### CSS formating

Most css is done through classes, and most of the basic classes are defined in `src\App.vue`. Though a lot of scss is fine tuned in components. (it surely could be refactored but hey, what can a man do in the time given?)


### Libraries used

* The canvas logic, which is used in `Exposition.vue` for placing the artwork and all this stuff is handled with KonvaJs *https://konvajs.org/*. The vue doc: *https://konvajs.org/docs/vue/index.html*. 
* Html requests to send DB requests: *https://axios-http.com/fr/
* vue-meta : *https://www.npmjs.com/package/vue-meta*. Allows to tune the meta data of the pages.
* vue-social-sharing: *https://www.npmjs.com/package/vue-social-sharing* to add the share button when possible.