
require 'oily_png'
require 'mini_magick'
require 'fileutils'

master = ChunkyPNG::Image.from_file('master.png')

x = 66365
y = 45104

(0..4).each do |i|
  
  (0..2).each do |j|
    
    x_crop = x + i
    y_crop = y + j

    p "#{x_crop} x #{y_crop}"
    
    new = master.crop(i * 1024, 512 + j * 1024, 1024, 1024)

    FileUtils.mkdir_p "17/#{x_crop}"
    
    dest = "17/#{x_crop}/#{y_crop}.png"
    
    new.save(dest, :fast_rgba)

    image = MiniMagick::Image.open(dest)
    image.resize "256x256"
    image.write dest
    
  end
  
end
