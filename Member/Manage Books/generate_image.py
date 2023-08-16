from PIL import Image, ImageDraw, ImageFont
import os, sys

def generate_placeholder_image(book_title, save_path):
    # Create a blank image with a white background (you can customize the size as needed)
    image = Image.new('RGB', (300, 150), color='white')
    
    # Use a truetype font (you can customize the font and size as needed)
    font = ImageFont.truetype('arial.ttf', 20)
    
    # Create a drawing context
    draw = ImageDraw.Draw(image)
    
    # Get the bounding box of the text
    text_bbox = draw.textbbox((0, 0), book_title, font=font)
    
    # Calculate the position to center the text on the image
    text_width = text_bbox[2] - text_bbox[0]
    text_height = text_bbox[3] - text_bbox[1]
    x = (image.width - text_width) // 2
    y = (image.height - text_height) // 2
    
    # Add the book title as text on the image
    draw.text((x, y), book_title, fill='black', font=font)
    
    # Save the image with a unique filename
    image_filename = f'{book_title}.png'
    image_filepath = os.path.join(save_path, image_filename)
    image.save(image_filepath)

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python script_name.py book_title save_location")
        sys.exit(1)
    
    book_title = sys.argv[1]
    save_location = r'C:\xampp\htdocs\LMS-project-main\LMS project\Book_Images'  # Set your desired save location here
    generate_placeholder_image(book_title, save_location)

# Example usage:
# generate_placeholder_image('The Great Gatsby', '/path/to/save/location')
# generate_placeholder_image('To Kill a Mockingbird', '/path/to/save/location')