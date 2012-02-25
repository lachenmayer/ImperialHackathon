package  
{
	import flash.display.Bitmap;
	import flash.display.Sprite;
	import flash.text.TextField;
	import flash.text.TextFormat;
	import flash.text.TextFormatAlign;
	/**
	 * ...
	 * @author Vojtech Havlicek
	 */
	public class Canvas extends Sprite
	{
		public var W:uint = 1366;
		public var H:uint = 768;
		
		public var headHeight:int = 100;
		
		/**
		 * DummyText
		 */
		//private var dummyText:TextField
		
		[Embed(source = "../lib/images/ImperialFoodie.png")]
		private var headImageSrc:Class;
		private var headImage:Bitmap;
		
		private var screenBlock:ScreenBlock;
		public function Canvas() 
		{
			
			/**
			 * Adds a dummy text to the screen
			 */
			var dummyText:TextField = new TextField();
			dummyText.defaultTextFormat = (new TextFormat("Helvetica", 64, 0x333333, true, null, null, null, null, TextFormatAlign.CENTER));
			dummyText.text = "The Imperial Foodie";
			dummyText.width = 1024;
			
			dummyText.x = (W - dummyText.width) * 0.5 - 200;
			dummyText.y = (headHeight - dummyText.textHeight) * 0.5 + 20;
			dummyText.mouseEnabled = false;
			addChild(dummyText);
			
			/*headImage = new headImageSrc() as Bitmap;
			addChild(headImage);*/
			
			screenBlock   = new ScreenBlock(this);
			screenBlock.y = headHeight;
			screenBlock.viewDummy();
			
			addChild(screenBlock)
		}
		
		/**
		 * Views the most popular food
		 */
		public function foodRank():void {}
		
		/**
		 * Views a comparison of food sold (e.g baguettes vs. sandwiches)
		 */
		public function foodWar():void { }
		
		
	}

}