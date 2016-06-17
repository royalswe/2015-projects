namespace Workshop_2.Model
{
    class Boat
    {
        public BoatType Type { get; set; }
        public int Length { get; set; }
        public Boat(BoatType Type, int Length)
        {
            this.Type = Type;
            this.Length = Length;
        }
    }
}
