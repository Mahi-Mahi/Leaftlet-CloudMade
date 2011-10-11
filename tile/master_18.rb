
require 'oily_png'
require 'mini_magick'
require 'fileutils'

master = ChunkyPNG::Image.from_file('master.png')

x = 132730
y = 90207

(1..7).each do |i|
  
  (1..6).each do |j|
    
    x_crop = x + i
    y_crop = y + j

    p "#{x_crop} x #{y_crop}"
    
    new = master.crop(i * 512, j * 512, 512, 512)

    FileUtils.mkdir_p "18/#{x_crop}"
    
    dest = "18/#{x_crop}/#{y_crop}.png"
    
    new.save(dest, :fast_rgba)

    image = MiniMagick::Image.open(dest)
    image.resize "256x256"
    image.write dest
    
  end
  
end
