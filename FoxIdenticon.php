<?php
/**
 * @ Author Said Bakr
 * https://github.com/saidbakr 
 * 
 */
namespace saidbakr;
class FoxIdenticon
{
    private static $map = [
        0 => [0,15],
        1 => [1,14],
        2 => [2,13],
        3 => [3,12],
        4 => [4,11],
        5 => [5,10],
        6 => [6,9],
        7 => [7,8],
        8 => [8,7],
        9 => [9,6],
        'a' => [10,5],
        'b' => [11,4],
        'c' => [12,3],
        'd' => [13,2],
        'e' => [14,1],
        'f' => [15,0]
    ];
    public static $salt;
    private static $hash;
    private static $image;
    private static $bgColor;
    private static $fgColor;
    private static $altColor;
    private static $size;
    private static $w;
    private static $thickBorder;
    private static $hasTrimmedBorder;
    private static function hash($input = '')
    {
        if (!empty(self::$salt))
        {
            self::$hash = md5(self::salting($input,self::$salt));
            
        }
        else
        {
            self::$hash = md5($input);            
        }
        
    }
    public function create($input = '', $size = 1, $hasTrimmedBorder = false, $thickBorder = false)
    {
        self::$hasTrimmedBorder = $hasTrimmedBorder;
        self::$thickBorder = $thickBorder;
        self::$size = $size?? 6;
        self::createImage($input);  
        header("Content-type: image/png; Cache-Control: no-store, no-cache, must-revalidate");
        imagepng(self::$image, null, 0);

    }
    private function makeSequence()
    {
        $x = [];
        $y = [];
        for ($i = 0; $i < strlen(self::$hash); $i++)
        {
            if ($i%2 === 0)
            {
                $x[] = self::$map[self::$hash[$i]];
            }
            else
            {
                $y[] = self::$map[self::$hash[$i]];
            }
        }
        $sequence = ['x' => $x, 'y' => $y];       
        return $sequence;
    }
    private function createImage($input)
    {
        self::hash($input);
        $w = 15*self::$size;
        self::$w = $w;
        $h = 15*self::$size;
        self::$image = imagecreate($w, $h);  
        imageantialias(self::$image, true);
        self::colorSet();
        self::drawLines(self::makeSequence());        
        //imagefilter(self::$image,IMG_FILTER_SMOOTH,6);        
    }
    
    private function colorSet(){        
		$red = hexdec(substr(self::$hash,0,2));
		$green = hexdec(substr(self::$hash,3,2));
		$blue = hexdec(substr(self::$hash,6,2));
		self::$bgColor = imagecolorallocate(self::$image, $red, $green, $blue);
		self::$fgColor = imagecolorallocate(self::$image, abs($red-255), abs($green-255), abs($blue-255));
        self::$altColor = imagecolorallocate(self::$image,abs($blue-255),abs($red-255),abs($green-255));
	}
	
	private function drawLines($sequence)
    {
        for ($i = 0; $i < count($sequence['x']); $i++)
        {
            $x1 = $sequence['x'][$i][0]*self::$size;
            $y1 = $sequence['y'][$i][0]*self::$size;
            $x2 = $sequence['x'][$i][1]*self::$size;
            $y2 = $sequence['y'][$i][1]*self::$size;
            self::imagelinethick(self::$image,$x1,$y1,$x2,$y2,self::$fgColor,2);
            $startPoints[] = [$x1,$y1];
            $endPoints[] = [$x2,$y2];
        }
        /*sort($startPoints);
        sort($endPoints);
        $rEndPoints = array_reverse($endPoints);
        for ($i = 0; $i < count($endPoints); $i++)
        {
            self::imagelinethick(self::$image,$startPoints[$i][0],$startPoints[$i][1],$endPoints[$i+1][0],$endPoints[$i+1][1],self::$altColor,3);
            self::imagelinethick(self::$image,$endPoints[$i][0],$endPoints[$i][1],$startPoints[$i+1][0],$startPoints[$i+1][1],self::$altColor,3);
            $i++;
        }*/
        if (self::$hasTrimmedBorder)
        {
            self::trimmedBorder();
        }
        
    }
    
    private function trimmedBorder()
    {
        self::imagelinethick(self::$image,0,0,self::$w-(self::$w/1.6),0,self::$fgColor,self::isThickBorder());
        self::imagelinethick(self::$image,0,0,0,self::$w-(self::$w/1.6),self::$fgColor,self::isThickBorder());
        
        self::imagelinethick(self::$image,self::$w/1.6,0,self::$w,0,self::$fgColor,self::isThickBorder());
        self::imagelinethick(self::$image,self::$w,0,self::$w,self::$w-(self::$w/1.6),self::$fgColor,self::isThickBorder());
        
        self::imagelinethick(self::$image,0,self::$w/1.6,0,self::$w,self::$fgColor,self::isThickBorder());
        self::imagelinethick(self::$image,0,self::$w,self::$w-(self::$w/1.6),self::$w,self::$fgColor,self::isThickBorder());
        
        self::imagelinethick(self::$image,self::$w,self::$w,self::$w/1.6,self::$w,self::$fgColor,self::isThickBorder());
        self::imagelinethick(self::$image,self::$w,self::$w,self::$w,self::$w/1.6,self::$fgColor,self::isThickBorder());        
    }
    private function isThickBorder()
    {
        if (self::$thickBorder)
        {
            return self::$size*1.6;
        }
        else
        {
            return self::$size/1.6;
        }
        
    }
    private function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1)
    {
        /* this way it works well only for orthogonal lines
        imagesetthickness($image, $thick);
        return imageline($image, $x1, $y1, $x2, $y2, $color);
        
        Coppied from the official PHP docs: https://www.php.net/manual/en/function.imageline.php Example #1
        */
        
        if ($thick == 1) {
            return imageline($image, $x1, $y1, $x2, $y2, $color);
        }
        $t = $thick / 2 - 0.5;//
        if ($x1 == $x2 || $y1 == $y2) {
            return imagefilledrectangle($image, (min($x1, $x2) - $t), (min($y1, $y2) - $t), (max($x1, $x2) + $t), (max($y1, $y2) + $t), $color);
        }
        $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
        $a = $t / sqrt(1 + pow($k, 2));
        $points = array(
            round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
            round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
            round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
            round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
        );
        imagefilledpolygon($image, $points, 4, $color);
        return imagepolygon($image, $points, 4, $color);
    }
    
    private function salting ($word, $salt)
    {            
        define('CUTLEN',2);
        $words = str_split($word,CUTLEN);
        $salts = str_split($salt,CUTLEN);
        $cWords = count($words);
        $cSalts = count($salts);    
        $output = '';
        if ($cWords > $cSalts)
        {
            $gr = $words;
            $sm = $salts;
        }
        else
        {
            $gr = $salts;
            $sm = $words;
        }
       // $grSm = array_merge($gr,$sm);
        for ($i=0; $i < count($gr); $i++)
        {   
            $output .= ($salts[$i] ?? '').($words[$i] ?? '');          
        }        
       // die($output.' '.strlen($output).' '.strlen($word).' '.strlen($salt).' =>'.count($words).$words[0]);
        return $output;
    }
}
