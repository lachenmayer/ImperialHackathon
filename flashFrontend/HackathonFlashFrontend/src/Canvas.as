package  
{
	import com.adobe.serialization.json.JSON;
	import com.greensock.TweenNano;
	import flash.display.Bitmap;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.TimerEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.text.TextField;
	import flash.text.TextFormat;
	import flash.text.TextFormatAlign;
	import flash.utils.Timer
	/**
	 * ...
	 * @author Vojtech Havlicek
	 */
	public class Canvas extends Sprite
	{
		public var W:uint = 1366;
		public var H:uint = 768;
		
		public var headHeight:int = 300;
		
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
			dummyText.defaultTextFormat = (new TextFormat("Helvetica", 72, 0x333333, true, null, null, null, null, TextFormatAlign.CENTER));
			dummyText.text = "The Imperial Foodie";
			dummyText.width = 1366;
			dummyText.height = 200;
			
			dummyText.x = (W - dummyText.width) * 0.5 - 210
			dummyText.y = (headHeight - dummyText.textHeight) * 0.5 + 20;
			dummyText.mouseEnabled = false;
			addChild(dummyText);
			
			/*headImage = new headImageSrc() as Bitmap;
			addChild(headImage);*/
			
			screenBlock   = new ScreenBlock(this);
			screenBlock.y = headHeight;
			addChild(screenBlock)
			
			screenBlock.showCalories();
			
			var t:Timer = new Timer(5000);
			t.addEventListener(TimerEvent.TIMER, ticker);
			t.start();
			ticker();
			
			
		}
		
		private var functionSequence:Array = [foodRank, bestShops];
		private var pointer:int = 0
		/**
		 * Ticker
		 */
		private function ticker(e:TimerEvent = null):void
		{
			var f:Function = functionSequence[pointer] as Function
			screenBlock.hideLeftField();
			
			TweenNano.delayedCall(0.5, f);
			pointer++
			pointer %= functionSequence.length;
		}
		 
		/**
		 * Views the most popular food
		 */
		public function foodRank():void 
		{
			var loader:URLLoader = new URLLoader();
			loader.load(new URLRequest("http://129.31.217.212/hthon/main/?type=topitem&latest=7&topamount=3"));
			loader.addEventListener(Event.COMPLETE, loaderComplete);
			screenName = "Top Food";
		}
		
		/**
		 * Listener on completion of data extraction
		 */
		private function loaderComplete(e:Event = null):void 
		{
			var jsonArray:Array = JSON.decode(URLLoader (e.target).data);
			var data:FoodData = new FoodData(screenName, [jsonArray[0].name, jsonArray[1].name, jsonArray[2].name]);
			screenBlock.viewRank(data);
			
		}
		
		/**
		 *
		 */
		private var screenName:String = "";
		public function bestShops():void 
		{
			var loader:URLLoader = new URLLoader();
			loader.load(new URLRequest("http://129.31.217.212/hthon/main/?type=topshop&latest=7&topamount=3"));
			loader.addEventListener(Event.COMPLETE, loaderComplete);
			screenName = "Top Shops";
		}
		/**
		 * Views a comparison of food sold (e.g baguettes vs. sandwiches)
		 */
		public function foodWar():void { }
		
		
	}

}