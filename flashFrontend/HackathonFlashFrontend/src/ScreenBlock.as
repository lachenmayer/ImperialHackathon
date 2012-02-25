package  
{
	import flash.display.Sprite;
	import flash.text.TextField;
	import flash.text.TextFormat;
	import flash.text.TextFormatAlign;
	/**
	 * ...
	 * @author Vojtech Havlicek
	 */
	public class ScreenBlock extends Sprite
	{
		private var W:uint 
		private var H:uint
		
		private var canvas:Canvas;
		
		private var textField:TextField
		
		/**
		 * Block element to view the data
		 * @param	canvas
		 * @param	name
		 */
		public function ScreenBlock(canvas:Canvas) 
		{
			W = canvas.W;
			H = canvas.H - canvas.headHeight;
			
			/**
			 * Creates the TextField for viewing the rank.
			 */
			textField        = new TextField();
			textField.width  = W * .66;
			textField.height = H * .8;
			textField.y      = 0.1 * H;
			textField.x      = 0.33 * 0.5 * W;
			textField.multiline = true;
			textField.defaultTextFormat = new TextFormat("Helvetica", 36, 0x333333, false, null, null, null, null, TextFormatAlign.LEFT, null, null, null, 20);
			textField.mouseEnabled = false;
			
			addChild(textField);
		}
		
		/**
		 * Views a dummy text;
		 */
		public function viewDummy():void 
		{
			textField.text = "1. Roastbeef baguette\n" + "2. Chicken sandwich\n" + "3. Roll\n";
		}
		
		/**
		 * method for viewing ranked data (0-5) based on checked FoodData
		 * @param	data
		 */
		public function viewRank(data:FoodData):void 
		{
			
		}
		
		
		
	}

}