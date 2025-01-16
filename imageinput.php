<?php $highlight = $_SESSION['highlight']; ?>
<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mx-2 mb-2" for="image">
    Imagen
</label>
<input class="appearance-none block mx-2 w-54 bg-gray-200 text-gray-700 border <?php if (!empty($messages["image"])) { echo "border-red-500"; } else { echo "border-gray-300 focus:border-gray-500"; }; ?> rounded py-3 px-4 <?php if ($highlight !== GENRES) { ?> mb-3 <?php } ?> leading-tight focus:outline-none focus:bg-white" id="image" name="image" type="file">
<p class="mt-1 mx-2 text-sm text-black-500 dark:text-black-300" id="file_input_help">PNG, SVG, JPG, JPEG (MAX: 1000x1000px).</p>
<p class="text-red-500 text-xs italic mx-2"><?php echo $messages['image'] ?></p>  
<?php if (isset($row['image'])) { ?><input type="hidden" name="oldimage" value="<?php echo $row['image']; ?>"><?php } ?>