package  
{
	import flash.display.Sprite;
	import flash.text.StyleSheet;
	import flash.text.TextField;
	import flash.text.TextFormat;
	import flash.text.TextFormatAlign;
	import com.greensock.TweenLite;
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
		private var rightTextField:TextField
		private var bottomTextField:TextField
		
		private var styleSheet:StyleSheet = new StyleSheet();
		
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
			textField.width  = W * .33;
			textField.height = H * .8;
			textField.y      = 0.1 * H;
			textField.x      = 0.20 * 0.5 * W;
			textField.multiline = true;
			textField.wordWrap = true;
		
			textField.defaultTextFormat = new TextFormat("Helvetica", 32, 0x333333, false, null, null, null, null, TextFormatAlign.LEFT, null, null, null, 20);
			
			rightTextField = new TextField();
			rightTextField.width = W * .33;
			rightTextField.height = H * .8;
			rightTextField.y      = 0.1 * H;
			rightTextField.x      = W*.45
			rightTextField.multiline = true;
			rightTextField.wordWrap = true;
			rightTextField.defaultTextFormat = new TextFormat("Helvetica", 32, 0x333333, false, null, null, null, null, TextFormatAlign.LEFT, null, null, null, 20);
			
			//textField.styleSheet = CSSGetter.CSSBootstrap;
		
			rightTextField.mouseEnabled = false;
			textField.mouseEnabled = false;
			
		
			addChild(rightTextField);
			addChild(textField);
			
		}
		
		/**
		 * Views a dummy text;
		 */
		public function viewDummy():void 
		{
			textField.htmlText = '<h1>Top Foods</h1><br><div class="span2">Cool</div>';
		}
		
		/**
		 * Show Calories
		 */
		public function showCalories():void 
		{
			rightTextField.defaultTextFormat = new TextFormat("Helvetica", 50, 0x333333, true, null, null, null, null, TextFormatAlign.LEFT, null, null, null, 20);
			rightTextField.text = "Imperial has spent\n";
			rightTextField.defaultTextFormat = new TextFormat("Helvetica", 32, 0x333333, false, null, null, null, null, TextFormatAlign.LEFT, null, null, null, 20);
			rightTextField.appendText('£2M for food today\n');
			
		}
		
		/**
		 * method for viewing ranked data (0-5) based on checked FoodData
		 * @param	data
		 */
		private var colors:Array = [0x89E0FA, 0xFFEC73, 0x73C75A, 0xF24949];
		private var k:uint = 0;
		public function viewRank(data:FoodData):void 
		{
			textField.alpha = 0;
			//textField.x = -W * .66;
			textField.defaultTextFormat = new TextFormat("Helvetica", 50, 0x333333, true, null, null, null, null, TextFormatAlign.LEFT, null, null, null, 20);
			textField.htmlText = data.dataName + '\n'
		
			
			for (var i :uint = 0; i < data.rank.length; i++)
			{
				k++
				textField.defaultTextFormat = new TextFormat("Helvetica", 32,colors[k%colors.length] , false, null, null, null, null, TextFormatAlign.LEFT, null, null, null, 20);
				textField.appendText(data.rank[i]+'\n');
			}
			
			//TweenLite.to(textField, 2, { x:0.29 * 0.5 * W} );
			TweenLite.to(textField, 0.5, { alpha:1 } );
		}
		
		
		/**
		 * Hides Left field
		 */
		public function hideLeftField():void 
		{
			TweenLite.to(textField, 0.5, { alpha:0 } );
			//TweenLite.to(textField, 2, { x: -W * .66 } );
		}
		
		
	}

}